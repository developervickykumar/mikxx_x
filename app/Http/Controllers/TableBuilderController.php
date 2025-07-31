<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableBuilder;
use App\Models\TableTemplate;
use App\Models\Sheet;
use App\Models\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Form;
use App\Models\Graph;
use Illuminate\Support\Facades\DB;

class TableBuilderController extends Controller
{
    public function index()
    {
        $tableBuilders = TableBuilder::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('table-builder.index', compact('tableBuilders'));
    }

    public function create()
    {
        return view('table-builder.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'columns' => 'required|array',
            'columns.*.name' => 'required|string|max:255',
            'columns.*.type' => 'required|string|in:text,number,decimal,date,datetime,boolean',
            'columns.*.required' => 'boolean',
            'columns.*.default' => 'nullable|string'
        ]);

        // Filter out empty columns
        $columns = collect($validated['columns'])
            ->filter(function ($column) {
                return !empty($column['name']);
            })
            ->values()
            ->toArray();

        if (empty($columns)) {
            return back()->withErrors(['columns' => 'At least one column is required.'])->withInput();
        }

        $tableBuilder = TableBuilder::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'columns' => $columns,
            'user_id' => auth()->id()
        ]);

        return redirect()
            ->route('table-builder.show', $tableBuilder)
            ->with('success', 'Table created successfully.');
    }

    public function show(TableBuilder $tableBuilder)
    {
        $this->authorize('view', $tableBuilder);
        return view('table-builder.show', compact('tableBuilder'));
    }

    public function edit(TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);
        return view('table-builder.edit', compact('tableBuilder'));
    }

    public function update(Request $request, TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'columns' => 'required|array',
            'columns.*.name' => 'required|string|max:255',
            'columns.*.type' => 'required|string|in:text,number,decimal,date,datetime,boolean',
            'columns.*.required' => 'boolean'
        ]);

        $tableBuilder->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'columns' => $validated['columns']
        ]);

        return redirect()
            ->route('table-builder.show', $tableBuilder)
            ->with('success', 'Table updated successfully.');
    }

    public function destroy(TableBuilder $tableBuilder)
    {
        $this->authorize('delete', $tableBuilder);
        
        $tableBuilder->delete();

        return redirect()
            ->route('table-builder.index')
            ->with('success', 'Table deleted successfully.');
    }

    public function generate(TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        try {
            DB::beginTransaction();

            $tableName = Str::snake($tableBuilder->name);
            
            // Create the table
            $columns = collect($tableBuilder->columns)->map(function ($column) {
                $type = match($column['type']) {
                    'text' => 'TEXT',
                    'number' => 'INTEGER',
                    'decimal' => 'DECIMAL(10,2)',
                    'date' => 'DATE',
                    'datetime' => 'DATETIME',
                    'boolean' => 'BOOLEAN',
                    default => 'TEXT'
                };

                return "`{$column['name']}` {$type}" . ($column['required'] ? ' NOT NULL' : '');
            })->join(', ');

            $sql = "CREATE TABLE IF NOT EXISTS `{$tableName}` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                {$columns},
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            )";

            DB::statement($sql);

            DB::commit();

            return redirect()
                ->route('table-builder.show', $tableBuilder)
                ->with('success', 'Table generated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('table-builder.show', $tableBuilder)
                ->with('error', 'Failed to generate table: ' . $e->getMessage());
        }
    }

    public function createForm(TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        $form = Form::create([
            'name' => $tableBuilder->name . ' Form',
            'description' => 'Form for ' . $tableBuilder->name,
            'fields' => $tableBuilder->columns,
            'validation_rules' => $tableBuilder->validation_rules,
            'field_dependencies' => $tableBuilder->column_dependencies,
            'field_comments' => $tableBuilder->column_comments,
            'layout' => [
                'type' => 'grid',
                'columns' => 2,
                'sections' => $this->generateFormSections($tableBuilder->columns)
            ],
            'template_id' => null,
            'user_id' => auth()->id(),
            'is_active' => true
        ]);

        return redirect()
            ->route('forms.show', $form)
            ->with('success', 'Form created successfully.');
    }

    public function createGraph(TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        $graph = Graph::create([
            'name' => $tableBuilder->name . ' Graph',
            'type' => 'bar',
            'config' => [
                'columns' => $tableBuilder->columns,
                'x_axis' => $tableBuilder->columns[0]['name'],
                'y_axis' => $tableBuilder->columns[1]['name'] ?? null,
                'filters' => [],
                'options' => [
                    'stacked' => false,
                    'show_legend' => true,
                    'show_grid' => true,
                    'show_labels' => true,
                    'animation' => true,
                    'colors' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                ]
            ],
            'data' => [],
            'user_id' => auth()->id()
        ]);

        return redirect()
            ->route('graphs.show', $graph)
            ->with('success', 'Graph created successfully.');
    }

    protected function generateFormSections(array $columns): array
    {
        $sections = [];
        $currentSection = [
            'title' => 'Main Information',
            'description' => 'Enter the main information',
            'fields' => []
        ];

        foreach ($columns as $index => $column) {
            if ($index > 0 && $index % 4 === 0) {
                $sections[] = $currentSection;
                $currentSection = [
                    'title' => 'Additional Information ' . count($sections) + 1,
                    'description' => 'Enter additional information',
                    'fields' => []
                ];
            }

            $currentSection['fields'][] = [
                'name' => $column['name'],
                'type' => $column['type'],
                'required' => $column['required'] ?? false,
                'default' => $column['default'] ?? null,
                'validation' => $column['validation'] ?? [],
                'dependencies' => $column['dependencies'] ?? [],
                'comment' => $column['comment'] ?? null
            ];
        }

        if (!empty($currentSection['fields'])) {
            $sections[] = $currentSection;
        }

        return $sections;
    }

    public function templatesIndex()
    {
        return response()->json(TableTemplate::where('user_id', Auth::id())->get());
    }

    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schema' => 'nullable|array',
            'settings' => 'nullable|array',
        ]);

        $template = TableTemplate::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'schema' => $validated['schema'] ?? [],
            'settings' => $validated['settings'] ?? [],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template created successfully',
            'data' => $template
        ]);
    }

    public function showTemplate(TableTemplate $template)
    {
        $template->load('sheets.widgets');
        return response()->json($template);
    }

    public function updateTemplate(Request $request, TableTemplate $template)
    {
        $template->update($request->only('name', 'description', 'schema', 'settings'));
        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully',
            'data' => $template
        ]);
    }

    public function deleteTemplate(TableTemplate $template)
    {
        $template->delete();
        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully'
        ]);
    }

    public function createSheet(Request $request, TableTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'data' => 'nullable|array',
            'settings' => 'nullable|array',
        ]);

        $sheet = $template->sheets()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? '',
            'data' => $validated['data'] ?? [],
            'settings' => $validated['settings'] ?? [],
            'order' => $template->sheets()->count() + 1,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sheet created',
            'data' => $sheet
        ]);
    }

    public function createWidget(Request $request, Sheet $sheet)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'config' => 'nullable|array',
            'data' => 'nullable|array',
        ]);

        $widget = $sheet->widgets()->create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'config' => $validated['config'] ?? [],
            'data' => $validated['data'] ?? [],
            'order' => $sheet->widgets()->count() + 1,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Widget created',
            'data' => $widget
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:json'
        ]);

        try {
            $jsonData = json_decode(file_get_contents($request->file('import_file')), true);
            
            if (!is_array($jsonData)) {
                throw new \Exception('Invalid JSON format');
            }

            DB::beginTransaction();

            foreach ($jsonData as $tableData) {
                TableBuilder::create([
                    'name' => $tableData['name'],
                    'description' => $tableData['description'] ?? null,
                    'columns' => $tableData['columns'],
                    'user_id' => auth()->id()
                ]);
            }

            DB::commit();

            return redirect()
                ->route('table-builder.index')
                ->with('success', 'Tables imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('table-builder.index')
                ->with('error', 'Failed to import tables: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $request->validate([
            'tables' => 'required|array',
            'tables.*' => 'exists:table_builders,id'
        ]);

        try {
            $tables = TableBuilder::whereIn('id', $request->tables)
                ->where('user_id', auth()->id())
                ->get()
                ->map(function ($table) {
                    return [
                        'name' => $table->name,
                        'description' => $table->description,
                        'columns' => $table->columns,
                        'created_at' => $table->created_at,
                        'updated_at' => $table->updated_at
                    ];
                });

            return response()->json($tables, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="tables_export.json"'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export tables: ' . $e->getMessage()], 500);
        }
    }

    public function duplicate(TableBuilder $tableBuilder)
    {
        $this->authorize('duplicate', $tableBuilder);

        try {
            DB::beginTransaction();

            $newTable = $tableBuilder->replicate();
            $newTable->name = $tableBuilder->name . ' (Copy)';
            $newTable->is_template = false;
            $newTable->user_id = auth()->id();
            $newTable->save();

            // Copy related data if any
            if ($tableBuilder->forms) {
                foreach ($tableBuilder->forms as $form) {
                    $newForm = $form->replicate();
                    $newForm->table_builder_id = $newTable->id;
                    $newForm->save();
                }
            }

            if ($tableBuilder->graphs) {
                foreach ($tableBuilder->graphs as $graph) {
                    $newGraph = $graph->replicate();
                    $newGraph->table_builder_id = $newTable->id;
                    $newGraph->save();
                }
            }

            DB::commit();

            return redirect()
                ->route('table-builder.show', $newTable)
                ->with('success', 'Table duplicated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('table-builder.show', $tableBuilder)
                ->with('error', 'Failed to duplicate table: ' . $e->getMessage());
        }
    }

    public function saveAsTemplate(TableBuilder $tableBuilder)
    {
        $this->authorize('manage', $tableBuilder);

        try {
            $template = $tableBuilder->replicate();
            $template->name = $tableBuilder->name . ' Template';
            $template->is_template = true;
            $template->user_id = auth()->id();
            $template->save();

            return redirect()
                ->route('table-builder.templates.show', $template)
                ->with('success', 'Table saved as template successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('table-builder.show', $tableBuilder)
                ->with('error', 'Failed to save template: ' . $e->getMessage());
        }
    }

    public function createFromTemplate(TableTemplate $template)
    {
        $this->authorize('use', $template);

        try {
            $table = $template->replicate();
            $table->name = $template->name . ' (New)';
            $table->is_template = false;
            $table->user_id = auth()->id();
            $table->save();

            return redirect()
                ->route('table-builder.show', $table)
                ->with('success', 'Table created from template successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('table-builder.templates.index')
                ->with('error', 'Failed to create table from template: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,generate,duplicate,export',
            'tables' => 'required|array',
            'tables.*' => 'exists:table_builders,id'
        ]);

        try {
            DB::beginTransaction();

            $tables = TableBuilder::whereIn('id', $request->tables)
                ->where('user_id', auth()->id())
                ->get();

            switch ($request->action) {
                case 'delete':
                    foreach ($tables as $table) {
                        $table->delete();
                    }
                    $message = 'Tables deleted successfully.';
                    break;

                case 'generate':
                    foreach ($tables as $table) {
                        $this->generate($table);
                    }
                    $message = 'Tables generated successfully.';
                    break;

                case 'duplicate':
                    foreach ($tables as $table) {
                        $this->duplicate($table);
                    }
                    $message = 'Tables duplicated successfully.';
                    break;

                case 'export':
                    return $this->export($request);
            }

            DB::commit();

            return redirect()
                ->route('table-builder.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('table-builder.index')
                ->with('error', 'Failed to perform bulk action: ' . $e->getMessage());
        }
    }

    public function updateCategory(Request $request, TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        $validated = $request->validate([
            'category' => 'required|string|max:255'
        ]);

        $tableBuilder->update([
            'category' => $validated['category']
        ]);

        return redirect()
            ->route('table-builder.show', $tableBuilder)
            ->with('success', 'Table category updated successfully.');
    }

    public function updateTags(Request $request, TableBuilder $tableBuilder)
    {
        $this->authorize('update', $tableBuilder);

        $validated = $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'string|max:50'
        ]);

        $tableBuilder->update([
            'tags' => $validated['tags']
        ]);

        return redirect()
            ->route('table-builder.show', $tableBuilder)
            ->with('success', 'Table tags updated successfully.');
    }

    public function search(Request $request)
    {
        $query = TableBuilder::query();

        // Search by name or description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter by tags
        if ($tags = $request->input('tags')) {
            $query->whereJsonContains('tags', $tags);
        }

        // Filter by user
        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        // Filter by template status
        if ($request->has('is_template')) {
            $query->where('is_template', $request->boolean('is_template'));
        }

        // Filter by shared status
        if ($request->has('is_shared')) {
            $query->where('is_shared', $request->boolean('is_shared'));
        }

        $tables = $query->paginate(10);

        return view('table-builder.index', compact('tables'));
    }

    public function getCategories()
    {
        $categories = TableBuilder::distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return response()->json($categories);
    }

    public function getTags()
    {
        $tags = TableBuilder::whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values();

        return response()->json($tags);
    }
}

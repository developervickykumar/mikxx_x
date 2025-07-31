<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DynamicPageController extends Controller
{
  public function save(Request $request)
  {
    $validated = $request->validate([
        'slug' => 'required|string',
        'routeContent' => 'nullable|string',
        'controllerContent' => 'nullable|string',
        'modelContent' => 'nullable|string',
        'viewContent' => 'nullable|string',
    ]);

    $slug = str_replace('/', '-', $validated['slug']);
    $slugCommentStart = "// === START routes for slug: {$slug} ===";
    $slugCommentEnd = "// === END routes for slug: {$slug} ===";

    $controllerDir = app_path("Http/Controllers/CategoryController");
    $controllerPath = "{$controllerDir}/" . ucfirst(str_replace('-', '', $slug)) . "Controller.php";

    $modelPath = app_path("Models/" . ucfirst(str_replace('-', '', $slug)) . ".php");
    $viewDir = resource_path("views/dynamic-pages/" . $slug);
    $routesFile = base_path("routes/dynamic-routes.php");

    // Create dirs if needed
    if (!File::exists($controllerDir)) {
        File::makeDirectory($controllerDir, 0755, true);
    }
    if (!File::exists($viewDir)) {
        File::makeDirectory($viewDir, 0755, true);
    }

    // Read existing routes or create default
    if (File::exists($routesFile)) {
        $routesContent = File::get($routesFile);
    } else {
        $routesContent = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n";
    }

    // Remove old block for this slug
    $pattern = sprintf(
        '/%s.*?%s/s',
        preg_quote($slugCommentStart, '/'),
        preg_quote($slugCommentEnd, '/')
    );
    $routesContent = preg_replace($pattern, '', $routesContent);

    // Detect controllers used in routeContent
    $controllerImports = [];
    if (!empty($validated['routeContent'])) {
        preg_match_all('/\[([A-Za-z0-9_\\\\]+)::class/', $validated['routeContent'], $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $ctrl) {
                $controllerImports[] = "use App\\Http\\Controllers\\CategoryController\\{$ctrl};";
            }
        }
    }
    $controllerImports = array_unique($controllerImports);
    $importString = implode("\n", $controllerImports);

    // Build new block
    $newBlock = trim("
{$slugCommentStart}

{$importString}

" . trim($validated['routeContent']) . "

{$slugCommentEnd}
");

    // Clean up spacing
    $routesContent = trim($routesContent);

    // Append new block
    $routesContent .= "\n\n" . $newBlock . "\n";

    // Save routes
    File::put($routesFile, $routesContent);

    // Save controller
    if (!empty($validated['controllerContent'])) {
        File::put($controllerPath, "<?php\n\nnamespace App\\Http\\Controllers\\CategoryController;\n\nuse Illuminate\\Http\\Request;\n\n" . $validated['controllerContent']);
    }

    // Save model
    if (!empty($validated['modelContent'])) {
        File::put($modelPath, "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\n" . $validated['modelContent']);
    }

    // Save view
    if (!empty($validated['viewContent'])) {
        File::put($viewDir . '/index.blade.php', $validated['viewContent']);
    }

    // return response()->json(['success' => true]);
    
    return response()->json([
        'success' => true,
        'slug' => $request->slug, // send actual URL-friendly slug back
    ]);

  }

 
    public function render($slug)
    {
        $slugPath = '/' . $slug;

        // Find the category matching this path
        $category = Category::where('path', $slugPath)->where('functionality', 'dynamic_page')->firstOrFail();

        // Optional: Fetch page-specific config or form structure
        $form = json_decode($category->create_form ?? '{}', true);

        return view('dynamic.templates.default', compact('category', 'form'));
    }
 
}

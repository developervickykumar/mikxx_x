<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    

     public function index()
    {
        
        $categories = Category::whereNull('parent_id')
            ->orWhere('parent_id', 0)
            ->with(['children'])
            ->orderBy('position')
            ->paginate(20);
            
        $labels = [
            "Categories", "Widgets", "Objects", "Products", "Page", "Tools", 
            "Services", "Integration", "Module", "Form", "Field", 
            "Field Functionality", "Templates"
        ];
        
        // One single grouped query
        $counts = Category::whereIn('label', $labels)
            ->groupBy('label')
            ->selectRaw('label, COUNT(*) as count')
            ->pluck('count', 'label');
        
        // Fill in 0 for labels that don't exist in the table
        $labelCounts = collect($labels)->mapWithKeys(function ($label) use ($counts) {
            return [$label => $counts->get($label, 0)];
        });

    
        $code = Category::whereRaw("TRIM(code) != '' AND code IS NOT NULL")->count();


    
    
        $dripicons = json_decode(file_get_contents(public_path('json/dripicons-icons.json')), true);
        $boxicons = json_decode(file_get_contents(public_path('json/boxicons-icons.json')), true);
        $fontawesomeIcons = json_decode(file_get_contents(public_path('json/fontawesome_simplified_icons.json')), true);
        $materialIcons = json_decode(file_get_contents(public_path('json/materialdesign-icons.json')), true);
    
        $fontawesomeList = [];
        foreach ($fontawesomeIcons as $icon) {
            $prefix = $icon['style'] === 'solid' ? 'fas' : ($icon['style'] === 'regular' ? 'far' : 'fab');
            $fontawesomeList[] = "$prefix fa-{$icon['id']}";
        }
    
        // 🔥 NEW: Get all named routes
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
            ];
        })->filter(function ($route) {
            return !is_null($route['name']); // Only routes with names
        })->sortBy('uri')->values();
    
        return view('backend.category.index', compact(
            'categories', 'dripicons', 'boxicons', 'fontawesomeList',
            'materialIcons', 'routes', 'labelCounts', 'code'
        ));
    }



    public function getChildrenHtml($id)
{
    $category = Category::with(['children'])->findOrFail($id);

    return view('backend.category.partials.children', [
        'children' => $category->children
    ]);
}

    

    public function create()
    {
        $categories = Category::whereNull('parent_id')->orWhere('parent_id', 0)->get();
        return view('backend.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulk_names' => 'nullable|string',
            'single_name' => 'nullable|string',
            'parent_id' => 'nullable',
            'level_name' => 'nullable|string',
            'conditions_text' => 'nullable|string',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
            'status' => 'nullable|in:active,inactive',
        ]);
    
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image.' . $image->getClientOriginalExtension();
            $image->storeAs('category/images', $imageName, 'public');
        }
    
        $iconName = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon.' . $icon->getClientOriginalExtension();
            $icon->storeAs('category/icons', $iconName, 'public');
        }
        
       $names = [];

        if ($request->filled('single_name')) {
            // Single name mode (even if it contains commas, treat it as one)
            $names = [trim($request->single_name)];
        } elseif ($request->filled('bulk_names')) {
            // Bulk mode
            $names = array_filter(array_map('trim', explode(',', $request->bulk_names)));
        } else {
            return back()->withErrors(['You must enter at least one subcategory name.']);
        }
            
        foreach ($names as $name) {
            Category::create([
                'name' => trim($name), 
                'parent_id' => $request->category_parent_id,
                'level_name' => $request->level_name,
            
                'conditions' => json_encode([
                    'conditions_text' => $request->conditions_text,   
                    'label_name' => is_array($request->label_name) ? array_filter($request->label_name) : [],
                ]),
            
                'status' => $request->status ?? 'active',
                'image' => $imageName,
                'icon' => $iconName,
            ]);
            
        }
    
        return response()->json(['message' => 'Category Types added successfully']);
    }
    
public function edit($id)
{
    $category = Category::findOrFail($id);

    // JSON-casted fields automatically handled by $casts
    $category->display_at_decoded = $category->display['display_at'] ?? null;
    $category->create_form_decoded = $category->display['create_form'] ?? false;
    $category->form_name = $category->display['form_name'] ?? null;

    $category->tooltip = $category->meta['tooltip'] ?? null;
    $category->validation = $category->meta['validation'] ?? null;
    $category->description = $category->meta['description'] ?? null;
    
    $category->functionality = $category['functionality'] ?? null;

    $category->meta_title = $category->seo['meta_title'] ?? null;
    $category->meta_description = $category->seo['meta_description'] ?? null;
    $category->meta_keywords = $category->seo['meta_keywords'] ?? null;

    $category->ratings = $category->advanced['ratings'] ?? null;
    $category->allow_user_options = $category->advanced['allow_user_options'] ?? null;
    
    $category->filters = $category->advanced['filters'] ?? [];
    $category->features = $category->advanced['features'] ?? [];
    $category->specs = $category->advanced['specs'] ?? [];
    $category->integrations = $category->advanced['integrations'] ?? [];
    $category->units = $category->advanced['units'] ?? [];
    $category->variants = $category->advanced['variants'] ?? [];
    $category->goods_services = $category->advanced['goods_services'] ?? [];

    $category->subscription_plans = $category->subscription_plans ?? [];
    $category->media = CategoryMedia::where('category_id', $id)->get();

    $category->label_json = $category->label_json ?? ['label' => null, 'subcategory' => null];
    
    $category->product_type = $category->meta['product_type'] ?? null;

    if ($category->product_type === 'digital') {
        $category->gift_value = $category->price_list['value'] ?? null;
        $category->value_type = $category->price_list['value_type'] ?? null;
        $category->conversion_rate = $category->price_list['conversion_rate'] ?? null;

        $category->theme = $category->price_list['theme'] ?? null;
        $category->is_collectible = $category->price_list['is_collectible'] ?? 0;
    }

    if ($category->product_type === 'service') {
        $category->service_duration = $category->price_list['service_duration'] ?? null;
        $category->service_area = $category->price_list['service_area'] ?? null;
    }

    if ($category->product_type === 'event') {
        $category->event_date = $category->price_list['event_date'] ?? null;
        $category->event_location = $category->price_list['event_location'] ?? null;
    }


    $category->conditions = [
        'orientation' => 'horizontal',
        'unit_type' => 'weight',
        'max_rating' => 5,
        'show_tooltip' => true,
    ];
    return response()->json($category);
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $category = Category::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($category->image) Storage::disk('public')->delete('category/images/' . $category->image);
        $image = $request->file('image');
        $imageName = time() . '_image.' . $image->getClientOriginalExtension();
        $image->storeAs('category/images', $imageName, 'public');
        $category->image = $imageName;
    }

    // Handle icon upload
    if ($request->hasFile('icon')) {
        if ($category->icon) Storage::disk('public')->delete('category/icons/' . $category->icon);
        $icon = $request->file('icon');
        $iconName = time() . '_icon.' . $icon->getClientOriginalExtension();
        $icon->storeAs('category/icons', $iconName, 'public');
        $category->icon = $iconName;
    }

    // Assign main fields
    $category->name = $request->name;
    $category->status = $request->status;

    // Label
    // $category->label_json = [
    //     'label' => $request->label ?? '',
    //     'subcategory' => $request->subcategory ?? null,
    //     'icon' => $request->icon ?? 'bx bx-purchase-tag',
    // ];
    
    $category->label =  $request->label;

    // Meta
    $category->meta = [
        'tooltip' => $request->tooltip ?? '',
        'validation' => $request->validation ?? '',
        'description' => $request->description ?? '',
        // 'functionality' => $request->functionality ?? '',
    ];

    // Display Options
    $category->display = [
        'display_at' => [
            'type' => $request->page_display_type ?? null,
            'positions' => $request->display_at ?? [],
        ],
        'create_form' => $request->has('create_form'),
        'form_name' => $request->form_name ?? ($request->name . ' Form'),
    ];

    // Group View
    $category->group_view = [
        'enabled' => $request->has('groupCategory'),
        'view_type' => $request->group_view_type ?? null,
    ];

    // Messages
    $category->messages = [
        'own' => $request->own_message ?? '',
        'user' => $request->user_message ?? '',
        'other' => $request->custom_message ?? '',
    ];

    // Notifications
    $category->notifications = [
        'own' => $request->own_notification ?? '',
        'user' => $request->user_notification ?? '',
        'other' => $request->custom_notification ?? '',
    ];

    // SEO
    $category->seo = [
        'meta_title' => $request->meta_title ?? '',
        'meta_description' => $request->meta_description ?? '',
        'meta_keywords' => $request->meta_keywords ?? '',
    ];

    // Advanced JSON field
    $category->advanced = [
        'allow_user_options' => $request->allow_user_options,
        'ratings' => $request->review_text ?? '',
        'filters' => is_array($request->filters) ? $request->filters : [],
        'features' => is_array($request->features) ? $request->features : [],
        'specs' => $request->default_specifications ?? ['key' => [], 'value' => []],
        'integrations' => $request->integrations ?? [],
        'variants' => $request->variants ?? [],
        'units' => [
            'unit_id' => $request->unit_id ?? null,
            'editable_type' => $request->editable_type ?? 'editable',
            'inputs' => $request->unit_inputs ?? [],
            'common_unit_id' => $request->common_unit_id ?? null,
        ],
        'goods_services' => [
            'owned_goods' => $request->input('owned-goods'),
            'owned_services' => $request->input('owned-services'),
            'suggestions_goods' => $request->input('suggestions-goods'),
            'suggestions_services' => $request->input('suggestions-services'),
            'suggestions_machinery' => $request->input('suggestions-machinery'),
            'suggestions_tools' => $request->input('suggestions-tools'),
            'suggestions_vendors' => $request->input('suggestions-vendors'),
            'suggestions_profile_type' => $request->input('suggestions-profile-type'),
        ],
        'modules' => [], // You can handle this later if needed
    ];
    
    $productMappings = json_decode($request->input('product_mappings_json'), true) ?? [];

$advanced = $category->advanced ?? [];
if (is_string($advanced)) {
    $advanced = json_decode($advanced, true);
}

// 🧠 Merge with existing structure
$advanced['product_mappings'] = $productMappings;

$category->advanced = $advanced;

    
        $category->level_name = $request->level_name ?? '';

    
    $category->functionality = $request->functionality ?? [];


    // Subscription Plans
    $category->subscription_plans = $request->subscription_plans ?? [];

    // Additional fields
    $category->price_list = $request->price_list ?? null;
    $category->code = $request->code ?? '';

    $category->save();
    
    
    if ($request->has('category-media-id')) {
        foreach ($request->input('category-media-id') as $mediaId) {
            $media = CategoryMedia::find($mediaId);
            if ($media) {
                $media->title = $request->input("category-media-title-$mediaId");
                $media->description = $request->input("category-media-description-$mediaId");
                $media->keywords = $request->input("category-media-keywords-$mediaId");
                $media->save();
            }
        }
    }
    
    

    return response()->json(['message' => 'Category updated successfully']);
}

    
// Example (storeAppLabel method)
public function storeAppLabel(Request $request)
{
    $request->validate([
        'parent_id' => 'required|integer|exists:categories,id',
        'label' => 'required|string',
        'subcategory' => 'nullable|string',
        'icon' => 'nullable|string', // new validation for icon
    ]);

    $labelData = [
        'label' => $request->input('label'),
        'subcategory' => $request->input('subcategory'),
        'icon' => $request->input('icon'), // save icon directly here
    ];

    $category = Category::findOrFail($request->input('parent_id'));
    $category->label_json = $labelData;
    $category->save();

    return response()->json(['success' => true, 'message' => 'App label updated successfully!']);
}

    

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        if ($category->image) {
            Storage::disk('public')->delete('category/images/' . $category->image);
        }
    
        if ($category->icon) {
            Storage::disk('public')->delete('category/icons/' . $category->icon);
        }
    
        $category->delete();
        return response()->json(['message' => 'Category and its subcategories deleted successfully']);
    }

public function reorder(Request $request)
{
    $ordered = $request->input('ordered', []);

    foreach ($ordered as $item) {
        Category::where('id', $item['id'])->update([
            'position' => $item['position']
        ]);
    }

    return response()->json(['message' => 'Categories reordered successfully.']);
}

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $targetId = $request->input('target_id');
        $ids = $request->input('category_ids', []);
    
        foreach ($ids as $id) {
            $category = Category::findOrFail($id);
    
            if ($action === 'copy') {
                $this->copyCategoryWithChildren($category, $targetId);
            }
    
            if ($action === 'move') {
                $category->parent_id = $targetId;
                $category->position = Category::where('parent_id', $targetId)->max('position') + 1;
                $category->save();
                // Children automatically move with parent — no need to update their parent_id
            }
        }
    
        return response()->json(['message' => 'Bulk operation completed successfully.']);
    }

    private function copyCategoryWithChildren(Category $original, $newParentId = null)
{
    // Duplicate the original
    $copy = $original->replicate();
    $copy->parent_id = $newParentId;
    $copy->position = Category::where('parent_id', $newParentId)->max('position') + 1;
    $copy->save();

    // Recursive copy for children
    foreach ($original->children as $child) {
        $this->copyCategoryWithChildren($child, $copy->id);
    }
}

    



    // public function search(Request $request)
    // {
    //     $query = $request->input('search');
    //     $categories = Category::where('name', 'LIKE', "%{$query}%")->with('children')->get();
    //     return view('backend.category.search-results', compact('categories'))->render();
    // }

    // public function show($name)
    // {
    //     $category = Category::find($name); // Use find() instead of findOrFail()
    
    //     if (!$category) {
    //         return response()->json(['message' => 'Category not found'], 404);
    //     }
    
    //     return response()->json($category);
    // }

    public function show($name)
    {
        $category = Category::where('name', $name)->first(); // Search by name
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        return response()->json($category);
    }
    
public function search(Request $request)
{
    $query = $request->input('search');

    // Fetch searched categories
    $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

    // Build full breadcrumb path for each
    foreach ($categories as $category) {
        $category->breadcrumbPath = $this->buildBreadcrumbPath($category);
    }

    // Debug: Show breadcrumb for first result (for testing)
    // dd($categories->pluck('breadcrumbPath'));

    return view('backend.category.search-result', compact('categories'));
}

    
private function buildBreadcrumbPath($category)
{
    $path = [];

    while ($category) {
        $path[] = [
            'id' => $category->id,
            'name' => $category->name,
        ];

        // Fetch next parent directly from DB
        $category = Category::find($category->parent_id); // ⬅️ This is the key line!
    }

    return array_reverse($path);
}


    public function copyCategory(Request $request, $id)
{
    $targetId = $request->input('target_id');
    $original = Category::with('children')->findOrFail($id);

    $newCategory = $original->replicate();
    $newCategory->parent_id = $targetId;
    $newCategory->name = $original->name;
    $newCategory->save();

    $this->duplicateChildren($original->children, $newCategory->id);

    return response()->json(['message' => 'Category copied successfully']);
}

protected function duplicateChildren($children, $parentId)
{
    foreach ($children as $child) {
        $newChild = $child->replicate();
        $newChild->parent_id = $parentId;
        $newChild->name = $child->name;
        $newChild->save();

        if ($child->children->count()) {
            $this->duplicateChildren($child->children, $newChild->id);
        }
    }
}


public function moveCategory(Request $request, $id)
{
    $targetId = $request->input('target_id');
    $category = Category::findOrFail($id);
    
    if ($targetId == $id || $this->isChild($id, $targetId)) {
        return response()->json(['message' => 'Invalid target. Cannot move category inside itself or child.'], 400);
    }

    $category->parent_id = $targetId;
    $category->save();

    return response()->json(['message' => 'Category moved successfully']);
}

protected function isChild($categoryId, $targetId)
{
    $target = Category::with('children')->find($targetId);
    if (!$target) return false;

    foreach ($target->children as $child) {
        if ($child->id == $categoryId || $this->isChild($categoryId, $child->id)) {
            return true;
        }
    }
    return false;
}


    public function verifyPin(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if (!$category->is_protected) {
            return response()->json(['status' => 'not_protected']);
        }

        $request->validate([
            'pin' => 'required|string|min:4|max:6'
        ]);

        $correctPin = env('PASSKEY', '1234'); // Set this in .env file

        if ($request->pin === $correctPin) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid PIN']);
        }
    }

    // public function toggleStatus(Request $request, $id)
    // {
    //     $category = Category::findOrFail($id);

    //     if ($category->is_protected) {
    //         return response()->json(['status' => 'protected', 'message' => 'PIN required']);
    //     }

    //     $category->status = ($category->status === 'active') ? 'inactive' : 'active';
    //     $category->save();

    //     return response()->json(['status' => 'success', 'message' => 'Status updated']);
    // }


    // CategoryController.php
public function updateStatus(Request $request, $id)
{
    $category = Category::findOrFail($id);

    if ($category->is_protected) {
        return response()->json(['status' => 'protected', 'message' => 'PIN required']);
    }

    $validStatuses = ['default', 'premium', 'enterprices', 'admin'];
    if (!in_array($request->status, $validStatuses)) {
        return response()->json(['status' => 'error', 'message' => 'Invalid status.']);
    }

    $category->status = $request->status;
    $category->save();

    return response()->json(['status' => 'success', 'message' => 'Status updated']);
}


    public function toggleProtection(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        // Validate the PIN only if it's provided
        $request->validate([
            'pin' => 'nullable|string|min:4|max:6',
        ]);
    
        $correctPin = env('PASSKEY', '1234');
    
        // If the category is protected, validate the PIN
        if ($category->is_protected && $request->pin !== $correctPin) {
            return response()->json(['status' => 'error', 'message' => 'Invalid PIN']);
        }
    
        // Toggle protection status
        $category->is_protected = !$category->is_protected;
        $category->save();
    
        return response()->json([
            'status' => 'success',
            'message' => $category->is_protected ? 'Category is now Protected' : 'Protection Removed',
        ]);
    }
    
public function updateIcon(Request $request, $id)
{
    $request->validate(['icon' => 'required|string']);
    $category = Category::findOrFail($id);
    $category->icon = $request->icon;
    $category->save();
    return response()->json(['message' => 'Icon updated']);
}

public function updateImage(Request $request, $id)
{
    $request->validate([
        'image' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,image/svg+xml|max:2048',

    ]);

    $category = Category::findOrFail($id);

    if ($category->image) {
        Storage::disk('public')->delete('category/images/' . $category->image);
    }

    $image = $request->file('image');
    $imageName = time() . '_image.' . $image->getClientOriginalExtension();
    $image->storeAs('category/images', $imageName, 'public');

    $category->image = $imageName;
    $category->save();

    return response()->json([
        'message' => 'Image updated successfully',
        'image_url' => asset('storage/category/images/' . $imageName)
    ]);
}


 
public function mediaUpload(Request $request)
{
    $request->validate([
        'media_file' => 'required|file|max:10240',
        'category_id' => 'required|exists:categories,id',
    ]);

    // Auto delete previous if you want 1 media per category only
    // Otherwise skip this part
    // $existing = CategoryMedia::where('category_id', $request->category_id)->first();
    // if ($existing) {
    //     Storage::disk('public')->delete($existing->file_path);
    //     $existing->delete();
    // }

    $file = $request->file('media_file');
    $path = $file->store('uploads/category/media', 'public');

    $media = CategoryMedia::create([
        'category_id' => $request->category_id,
        'file_name' => $file->getClientOriginalName(),
        'file_path' => $path,
        'file_type' => explode('/', $file->getMimeType())[0],
        'mime_type' => $file->getMimeType(),
        'meta' => json_encode(['size' => $file->getSize()])
    ]);

    return response()->json([
        'success' => true,
        'file_url' => asset('storage/' . $path),
        'media_id' => $media->id,
    ]);
}


public function mediaUpdate(Request $request, $id)
{
    $media = CategoryMedia::findOrFail($id);
    $media->update([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'keywords' => $request->input('keywords'),
    ]);

    return response()->json(['success' => true]);
}

public function categoryMediaDestroy($id)
{
    $media = CategoryMedia::findOrFail($id);

    // Delete file from storage
    Storage::disk('public')->delete($media->file_path);

    $media->delete();

    return response()->json(['success' => true]);
}






public function getChildrenByName($name)
{
    $parent = Category::where('name', $name)->first();

    if (!$parent) {
        return response()->json(['status' => false, 'message' => 'Category not found']);
    }

    // Fetch all child categories of "Unit"
    $children = Category::where('parent_id', $parent->id)->orderBy('position')->get();

    return response()->json([
        'status' => true,
        'children' => $children
    ]);
}



public function getChildren($id)
{

    // dd($id);
   if ($id == '0') {
    $categories = Category::where(function ($query) {
        $query->whereNull('parent_id')
              ->orWhere('parent_id', 0);
    })
    ->with('children')
    ->orderBy('position')
    ->get();
    } else {
        $categories = Category::where('parent_id', $id)
            ->with('children')
            ->orderBy('position')
            ->get();
    }
    // dd($categories);

    return view('backend.category.child-categories', compact('categories'));
}

 public function getCounts($id)
{
    // Step 1: Cache excluded category IDs (including their children)
    $excludedIds = Cache::remember('excluded_category_ids', 600, function () {
        return collect(DB::select("
            WITH RECURSIVE excluded_tree AS (
                SELECT id FROM categories WHERE is_excluded = 1
                UNION ALL
                SELECT c.id FROM categories c
                INNER JOIN excluded_tree et ON c.parent_id = et.id
            )
            SELECT id FROM excluded_tree
        "))->pluck('id')->toArray();
    });

    // Step 2: Initialize stats structure
    $stats = [
        'home' => 0,
        'sector' => 0,
        'department' => 0,
        'segment' => 0,
        'pages' => 0,
        'forms' => 0,
        'code' => 0,
    ];

    // Step 3: Determine root or non-root context
    $childIds = collect();

    if ($id == 0) {
        $homeIds = Category::where(function ($q) {
                $q->whereNull('parent_id')->orWhere('parent_id', 0);
            })
            ->whereNotIn('id', $excludedIds)
            ->pluck('id');

        $stats['home'] = $homeIds->count();
        $childIds = $homeIds;
    } else {
        $childIds = collect([$id]);
    }

    // Step 4: Drill 1 — Sectors or Departments (1st level children)
    $level1 = Category::whereIn('parent_id', $childIds)
        ->whereNotIn('id', $excludedIds)
        ->pluck('id');
 
        $stats['sector'] = $level1->count();

 
    $level2 = Category::whereIn('parent_id', $level1)
        ->whereNotIn('id', $excludedIds)
        ->pluck('id');

    $stats['department'] = $level2->count();
     
    
    $level3 = Category::whereIn('parent_id', $level2)
            ->whereNotIn('id', $excludedIds)
            ->pluck('id');

    // Step 5: Drill 3 — Segments (3rd level)
    $stats['segment'] = $level3->count();

    // Step 6: Final — Pages / Forms / Code (under segment level)
    $stats['pages'] = Category::whereIn('parent_id', $level2)
        ->whereNotIn('id', $excludedIds)
        ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(label_json, '$.label')) = 'Page'")
        ->count();

    $stats['forms'] = Category::whereIn('parent_id', $level2)
        ->whereNotIn('id', $excludedIds)
        ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(label_json, '$.label')) = 'Form'")
        ->count();

    $stats['code'] = Category::whereIn('parent_id', $level2)
        ->whereNotIn('id', $excludedIds)
        ->whereRaw("TRIM(code) != '' AND code IS NOT NULL")
        ->count();

    // Step 7: Return
    return response()->json($stats);
}


public function getChildrens($id)
{

    $children = Category::where('parent_id', $id)
        ->orderBy('position')
        ->get(['id', 'name']);
    return response()->json($children);
}



public function filterByLabel($label)
{
    
    $categories = Category::where('label', $label )
        ->with(['children'])
        ->orderBy('position')
        ->get();

    $view = view('backend.category.child-categories', compact('categories'))->render();

    return response()->json([
        'html' => $view,
        'count' => $categories->count()
    ]);
}


// CategoryController.php
public function getIconByLabel($label)
{
    $category = Category::where('name', $label)->first();

    if ($category && $category->icon) {
        return response()->json(['success' => true, 'icon' => $category->icon]);
    }

    return response()->json(['success' => false, 'icon' => 'bx bx-purchase-tag']);
}

public function getDirectSubcategories($id)
{
    $parent = Category::findOrFail($id);
    $children = Category::where('parent_id', $id)->orderBy('position')->pluck('name')->toArray();

    $line = $parent->name . ' - ' . implode(', ', $children);

    return response()->json([
        'formatted' => $line,
        'children' => $children,
        'parent' => $parent->name
    ]);
}


public function loadTemplate($id)
{
    $grand = Category::findOrFail($id);

    // Optional: eager load related models
    $html = view('partials.category-template', compact('grand'))->render();

    return response($html);
}


public function updateCode(Request $request, $id)
{
    $request->validate([
        'html_code' => 'required|string'
    ]);

    $category = Category::findOrFail($id);
    $category->code = $request->html_code;
    $category->save();

    return response()->json(['status' => 'success']);
}



public function showQuickAccess($id)
{
    $category = Category::findOrFail($id);
    
  

    return view('backend.category.quick_access_view', [
        'category' => $category,
    ]);
}

 public function togglePublish(Request $request)
{
    $category = Category::findOrFail($request->id);
    $category->is_published = !$category->is_published;
    $category->save();

    return response()->json([
        'success' => true,
        'new_status' => $category->is_published ? 'Published' : 'Draft',
        'new_class' => $category->is_published ? 'bg-success' : 'bg-secondary'
    ]);
}

 
 
public function autoAssignIconsFromJson()
{
    try {
        // ✅ Custom manual keyword-icon map
        $manualMap = [
            'student' => 'mdi mdi-account-school',
            'students' => 'mdi mdi-account-school-outline',
            'sports' => 'mdi mdi-basketball',
            'athlete' => 'mdi mdi-run-fast',
            'coach' => 'mdi mdi-whistle',
            'trainer' => 'mdi mdi-account-tie',
            'artist' => 'mdi mdi-palette',
            'music' => 'mdi mdi-music',
            'dance' => 'mdi mdi-dance-ballroom',
            'fashion' => 'mdi mdi-tshirt-crew',
            'photography' => 'mdi mdi-camera',
            'film' => 'mdi mdi-filmstrip',
            'video' => 'mdi mdi-video',
            'blogger' => 'mdi mdi-pencil',
            'influencer' => 'mdi mdi-star-outline',
            'businessman' => 'mdi mdi-briefcase-account',
            'professional' => 'mdi mdi-account-tie',
            'skilled' => 'mdi mdi-hammer-wrench',
            'government' => 'mdi mdi-city-variant-outline',
            'political' => 'mdi mdi-account-group',
            'unemployed' => 'mdi mdi-account-alert',
        ];

        // Fetch only 50 categories with blank icons
        $categories = Category::where(function ($q) {
            $q->whereNull('icon')->orWhere('icon', '');
        })->limit(50)->get();

        $updatedCount = 0;

        foreach ($categories as $category) {
            $icon = null;
            $catName = strtolower($category->name);

            foreach ($manualMap as $keyword => $iconClass) {
                if (Str::contains($catName, $keyword)) {
                    $icon = $iconClass;
                    break;
                }
            }

            if ($icon) {
                $category->icon = $icon;
                $category->save();
                $updatedCount++;
            }
        }

        return response()->json([
            'status' => 'success',
            'updated' => $updatedCount
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'Exception',
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ], 500);
    }
}


}
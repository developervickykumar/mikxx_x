<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\VehicleDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Iluminate\Support\Facedes\DB;
class VehicleController extends Controller
{
   
    
  

  public function product()
  {
    if(Auth::check())
    {
     $rootParentId = 93829;
        $productTypes = Category::where('parent_id', $rootParentId)->get();
        return view('product', compact('productTypes'));
    }
  } 



   
    public function fetchChildren($id)
    {
        $cat = Category::with('child.child.child')->findOrFail($id);
        // return either child categories or step definitions
        return response()->json($cat->child);
    }

    // Handle form submission
    public function pstore(Request $request)
    {
         if(Auth::check())
       {
        // Validate and save your dynamic form data here
         print_r($request->all());
        //return back()->with('success', 'Data submitted successfully!');
          
         $data = [];
          $request->validate([
        'level1' => 'required',
        'level2' => 'required',
        'level3' => 'required',
    ]);

    foreach ($request->except('_token','level1', 'level2', 'level3') as $key => $value) {
        // File upload handling
        if ($request->hasFile($key)) {
           $file = $request->file($key);
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('uploads/vehicles'), $filename);
    $data[$key] =  $filename;
        }
        // If it's an array (like checkbox options)
        elseif (is_array($value)) {
            $data[$key] = json_encode($value);
        } else {
            $data[$key] = $value;
        }
    }

    VehicleDetail::create([
        'user_id' => Auth::id(),
        'level1'=>$request->input('level1'),
        'level2'=>$request->input('level2'),
         'level3'=>$request->input('level3'),
        'data' => json_encode($data)
    ]);

    return back()->with('success', 'Vehicle data saved successfully!');
       }
       else
    {
      return redirect('login');
    }
    }
    //view page

  
  
      public function prodview( Request $request)
      {
       if(Auth::check())
       {
         $level3 = $request->input('id');
        $level1 = null;
        $level2 = null;
       
        if($level3)
        {
            $cat3 = Category::find($level3);
            if($cat3)
            {
                $level2 = $cat3->parent_id;
                $cat2 =Category::find($level2);
                $level1 = $cat2 ? $cat2->parent_id :null;
                
            }
            $request->merge([
                'level1'=>$level1,
                'level2' =>$level2,
                'level3' => $level3,
            ]);
        }
    $query = VehicleDetail::with('user');

    if ($request->level1) {
        $query->where('level1', $request->level1);
    }

    if ($request->level2) {
        $query->where('level2', $request->level2);
    }

    if ($request->level3) {
        $query->where('level3', $request->level3);
    }

    $vehicles = $query->paginate(10); // ✅ Proper pagination

    $productTypes = Category::where('parent_id','93829')->get();
    $categories = Category::all()->keyBy('id');

    return view('prodview', compact('vehicles', 'productTypes', 'categories'));
}
       else
    {
      return redirect('login');
    }
}

//import google sheert
/*public function importCSV(Request $request)
{
     if(Auth::check())
       {
      $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx'
      ]);
       
       $file = $request->file('csv_file');
       $extension = $file->getClientOriginalExtension();

       if($extension === 'csv' || $extension === 'txt')
       {
        $handle = fopen($file->getRealPath(),'r');
        $header = fgetcsv($handle);
        while(($row = fgetcsv($handle)) !==false)
        {
            $rowData = array_combine($header,$row);
            $level1 = $rowData['level1'] ?? null;
            $level2 = $rowData['level2'] ?? null;
            $level3 = $rowData['level3'] ?? null;
            unset($rowData['level1'],$rowData['level2'],$rowData['level3']);
        
            VehicleDetail::create([
             'level1' => $level1,
             'level2' => $level2,
             'level3' => $level3,
             'data' =>json_encode($rowData),
            ]);
        }
        fclose($handle);
       }
       elseif($extension === 'xlsx')
       {
        $data = readXlsx($file->getRealPath());

        if(!empty($data))
        {
            $header = $data[0];
            unset($data[0]);
            foreach( $data as $row)
            {
                $rowData = array_combine($header,$row);

                $level1 = $rowData['level1'] ?? null;
                $level2 = $rowData['level2']  ?? null;
                $level3 = $rowData['level3'] ?? null;
                 
                unset($rowData['level1'],$rowData['level2'],$rowData['level3']);

                VehicleDetail::create([
                  'level1' => $level1,
                  'level2' => $level2,
                  'level3' => $level3,
                  'data' => json_encode($rowData),
                ]);
            }
        }
        else 
        {
            return redirect()->back()->with('error','file is empty');
        }
       }
       return redirect()->back()->with('success','File imported successfully');
       }
       else
    {
      return redirect('login');
    }
}*/

/*public function importCSV(Request $request)
{
    if(!Auth::check()){
        return view('login');
    }
    $request->validate([
        'csv_file'=> 'required|file|mimes:csv,txt,xlsx'
    ]);
    $file= $request->file('csv_file');
    $extension = $file->getClientOriginalExtension();

    $insertableColumn = [
        'name','level_name','parent_id','position','level','conditions','path','image','icon','is_producted',
        'priority','functionality','group_view','code','status','created_at','update_at','messages','notifications','price_list',
        'create_form','label_json','meta','display','seo','is_excluded','advanced','subscription_plan','is_published'
    ];
    if($extension === 'csv' || $extension=== 'txt'){
        $handle = fopen($file->getRealPath(),'r');
        $header = fgetcsv($handle);
        while(($row = fgetcsv($handle)) !== false)
        {
            $rewData = array_combine($header, $row);

            $dataToInsert = [];
            foreach($insertableColumn as $col)
            {
                $dataToInsert[$col] = $rowData[$col] ?? null;
            }
            Category::create($dataToInsert);
        }
        fclose($handle);
    }
    elseif($extension === 'xlsx')
    {
        $data = readXlsx($file->getRealPath());

        if(!empty($data)){
            $header = $data[0];
            unset($data[0]);

            foreach($data as $row)
            {
                $rowData = array_combine($header,$row);
                $dataToInsert = [];
                foreach($insertableColumns as $col)
                {
                    $dataToInsert[$col] = $rowData[$col] ?? null;

                }
                Category::create($dataToInsert);
            }

        }
        else {
            return redirect()->back()->with('error','file is empty');
        }
    
    }
    return redirect()->back()->with('success','File imported successfully');
}*/
/*public function importCSV(Request $request)
{
    if (!Auth::check()) {
        return view('login');
    }

    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt,xlsx'
    ]);

    $file = $request->file('csv_file');
    $extension = $file->getClientOriginalExtension();

    $insertableColumn = [
        'name','level_name','parent_id','position','level','conditions','path','image','icon','is_producted',
        'priority','validation','tooltip','description','functionality','display_at','group_view','code','status','created_at','label','update_at','messages','notifications','price_list',
        'create_form','label_json','meta','display','seo','is_excluded','advanced','subscription_plan','is_published'
    ];

    if ($extension === 'csv' || $extension === 'txt') {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $rowData = array_combine($header, $row); // ✅ fixed name

            if (empty($rowData['name'])) {
                // skip rows without name
                continue;
            }

            $dataToInsert = [];
            foreach ($insertableColumn as $col) {
                $dataToInsert[$col] = $rowData[$col] ?? null;
            }

            Category::create($dataToInsert);
        }

        fclose($handle);

    } elseif ($extension === 'xlsx') {
    $data = readXlsx($file->getRealPath());
    
    if (!empty($data)) {
        $header = array_map(fn($h) => strtolower(trim($h)), $data[0]);
        unset($data[0]);

        foreach ($data as $row) {
            // ✅ row ko normalize karo
            if (count($header) !== count($row)) {
                $row = array_pad($row, count($header), null); // missing values → null
                $row = array_slice($row, 0, count($header)); // extra values → trim
            }

            $rowData = array_combine($header, $row);

            if (empty($rowData['name'])) {
                continue; // skip blank rows
            }

            $dataToInsert = [];
            foreach ($insertableColumn as $col) {
                  if ($col === 'status') {
                        $dataToInsert[$col] = $rowData[$col] ?? 'active';
                    } else {
                        $dataToInsert[$col] = $rowData[$col] ?? null;
                    }
            }
             
            dd($dataToInsert);
            Category::create($dataToInsert);
        }
    } else {
        return redirect()->back()->with('error', 'File is empty');
    }
}
    return redirect()->back()->with('success', 'File imported successfully');
}*/

public function importcsv(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:csv,txt,xlsx'
    ]);

    $file = $request->file('file');
    $extension = strtolower($file->getClientOriginalExtension());
    $path = $file->getRealPath();

    // ✅ Allowed DB columns (as per your Category model)
    $insertableColumn = [
        'name','position','parent_id','level','status','image','icon','is_protected',
        'label','label_json','meta','display','messages','notifications','group_view',
        'price_list','code','seo','advanced','subscription_plans','is_excluded','is_published'
    ];

    // ✅ Aliases (header fix)
    $aliases = [
        'is_producted'      => 'is_protected',
        'subscription_plan' => 'subscription_plans',
        'update_at'         => 'updated_at', // अगर कहीं गलती से आया तो
    ];

    $rows = [];

    // --- CSV / TXT Import ---
    if ($extension === 'csv' || $extension === 'txt') {
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);

        // normalize header
        $header = array_map(fn($h) => strtolower(trim($h)), $header);
        $header = array_map(fn($h) => $aliases[$h] ?? $h, $header);

        while (($row = fgetcsv($handle)) !== false) {
            if (count($header) !== count($row)) {
                $row = array_pad($row, count($header), null);
                $row = array_slice($row, 0, count($header));
            }
            $rows[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    // --- Excel (XLSX) Import ---
    elseif ($extension === 'xlsx') {
        $data = readXlsx($path);
        if (empty($data) || count($data) < 2) {
            return redirect()->back()->with('error', 'Excel file is empty or invalid.');
        }

        $header = array_map(fn($h) => strtolower(trim($h)), $data[0]);
        $header = array_map(fn($h) => $aliases[$h] ?? $h, $header);

        foreach (array_slice($data, 1) as $row) {
            if (count($header) !== count($row)) {
                $row = array_pad($row, count($header), null);
                $row = array_slice($row, 0, count($header));
            }
            $rows[] = array_combine($header, $row);
        }
    }

    // ✅ Prepare insert data
    $insertData = [];
   dd($insertData);
    foreach ($rows as $rowData) {
        if (empty($rowData['name'])) {
            continue; // skip empty rows
        }

        // Only allowed columns
        $rowData = array_intersect_key($rowData, array_flip($insertableColumn));

        // Default status
        if (empty($rowData['status'])) {
            $rowData['status'] = 'active';
        }

        // Clean values
        foreach ($rowData as $k => $v) {
            if ($v === '' || $v === null) {
                $rowData[$k] = null;
            }
        }

        $rowData['created_at'] = now();
        $rowData['updated_at'] = now();

        $insertData[] = $rowData;
    }

    dd($insertData);
    // ✅ Save in DB
    if (!empty($insertData)) {
        DB::table('categories')->insert($insertData);
    } else {
        return redirect()->back()->with('error', 'No valid rows found in file.');
    }

    return redirect()->back()->with('success', 'File imported successfully.');
}

//export the data in excel or csv file 
public function  export($type = 'csv')
{
    if(Auth::check())
       {
   $fileName = 'products.' . $type;
    $filePath = 'exports/' . $fileName;

    $products = VehicleDetail::with('user')->get();

    // Collect all unique JSON keys
    $jsonKeys = [];
    foreach ($products as $product) {
        $data = json_decode($product->data, true);
        if (is_array($data)) {
            $jsonKeys = array_merge($jsonKeys, array_keys($data));
        }
    }
    $jsonKeys = array_unique($jsonKeys);

    $columns = array_merge(['ID', 'User', 'Level1', 'Level2', 'Level3'], $jsonKeys);

    // Write to file
    $csv = fopen(storage_path("app/{$filePath}"), 'w');
    fputcsv($csv, $columns);

    foreach ($products as $product) {
        $data = json_decode($product->data, true);
        $row = [
            $product->id,
            optional($product->user)->name,
            $product->level1,
            $product->level2,
            $product->level3,
        ];
        foreach ($jsonKeys as $key) {
            $row[] = $data[$key] ?? '';
        }
        fputcsv($csv, $row);
    }

    fclose($csv);

    return response()->download(storage_path("app/{$filePath}"))->deleteFileAfterSend(true);
       }
       else
    {
      return redirect('login');
    }
}

public function productBuilder()
{
   $builderCategory = Category::where('name', 'builders')->first();
    
        $formCategory = optional($builderCategory)
            ->children()
            ->where('name', 'Form')
            ->first();
    
        if (!$formCategory) {
            abort(404, "Form category not found.");
        }
    
        $formSubCategories = $formCategory->children()->where('status', 'active')->get();
    
        $groupedSubCategories = [];
    
        foreach ($formSubCategories as $subCategory) {
            if (!is_object($subCategory) || !isset($subCategory->name)) {
                \Log::error("Invalid subCategory:", ['data' => $subCategory]);
                continue;
            }
    
            $groupedSubCategories[$subCategory->name] = $subCategory->children()->where('status', 'active')->get();
        }
        
            $modules = Category::where('name', 'modules')->first();
          
             $userCategory = Category::where('name', 'user')->first();
        $userCategories = $userCategory ? $userCategory->children()->where('status', 'active')->get() : [];

        $pageCategory = Category::where('name', 'pages')->first(); 
        $pageCategories = $pageCategory ? $pageCategory->children()->where('status', 'active')->get() : [];

        $functionalityCategory = Category::where('name', 'functionality')->first(); 
        $functionalityCategories = $functionalityCategory ? $functionalityCategory->children()->where('status', 'active')->get() : [];
        
        $defaultForms = Category::where('label->label', 'Form')->get();
        
         $rootParentId = 93829;
        $productTypes = Category::where('parent_id', $rootParentId)->get();
        
        $fieldType = Category::where('parent_id', 134510)
        ->with('child')
        ->get();
     return view('productBuilder', [
            'groupedSubCategories' => $groupedSubCategories,
            'formCategory' => $formCategory,
            'modules' => $modules,
            'userCategories'=>$userCategories,
            'pageCategories'=>$pageCategories, 
            'functionalityCategories'=>$functionalityCategories,
             'defaultForms'=> $defaultForms,
             'productTypes'=>$productTypes,
             'fieldType'=> $fieldType,
        ]);
}

public function vehi()
{
    return view('vehi');
}
public function embed($id)
{

    // Example: parent_id = 16256 ke child fields nikal rahe hain
    $steps  = Category::where('parent_id', $id)->with('child')->get();

    // Yaha assume karte hain ki tumne structure JSON ke form me store kiya hai
    //$steps = json_decode($categories->first()->structure ?? '[]', true);

    return view('embed', compact('steps'));
}
}
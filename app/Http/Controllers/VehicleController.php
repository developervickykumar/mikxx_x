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
use PhpOffice\PhpSpreadsheet\IOFactory;
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

/*public function importcsv(Request $request)
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
}*/
/*public function importCSV(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt,xlsx'
    ]);

    $file = $request->file('csv_file');
    $extension = $file->getClientOriginalExtension();

    // ---- Default JSON structures ----
    $jsonDefaults = [
        'meta' => [
            "meta_title" => "",
            "meta_description" => "",
            "meta_keywords" => ""
        ],
        'tooltip' => [
            "tooltip" => "",
            "validation" => "",
            "description" => ""
        ],
        'validation' => [
            "product_type" => null,
            "value" => null,
            "conversion_rate" => null,
            "theme" => null,
            "service_duration" => null,
            "service_area" => null,
            "event_date" => null,
            "event_location" => null
        ],
        'seo' => [],
        'advanced' => [],
        'subscription_plans' => [],
        'messages' => [],
        'notifications' => [],
        'price_list' => [],
        'label_json' => [],
        'display' => [],
        'group_view' => [],
    ];

   $boolFields = ['is_excluded','is_published','is_protected'];
   
    // ---- CSV / TXT ----
    if (in_array($extension, ['csv','txt'])) {
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $rowData = $this->normalizeRow($header, $row);

            // status default
            if (empty($rowData['status'])) {
                $rowData['status'] = 'active';
            }

            $this->saveRow($rowData, $jsonDefaults, $boolFields);
        }
    }

    // ---- XLSX ----
    elseif ($extension === 'xlsx') {
        $data = $this->readXlsx($file->getRealPath());

        if (!empty($data)) {
            $header = array_map(fn($h) => strtolower(trim($h)), $data[0]);
            unset($data[0]);

            foreach ($data as $row) {
                $rowData = $this->normalizeRow($header, $row);

                // status default
                if (empty($rowData['status'])) {
                    $rowData['status'] = 'active';
                }

                $this->saveRow($rowData, $jsonDefaults, $boolFields);
            }
        }
    }

    return back()->with('success', 'File imported successfully!');
}

/**
 * ✅ Row normalize (numbers fix + header match)
 */
/*private function normalizeRow($row)
{
    // default JSON structures
    $jsonDefaults = [
        'label_json' => '{}',
        'meta' => '{"meta_title":"","meta_description":"","meta_keywords":""}',
        'display' => '[]',
        'messages' => '[]',
        'notifications' => '[]',
        'group_view' => '[]',
        'price_list' => '{"product_type":null,"value":null,"conversion_rate":null,"theme":null,"service_duration":null,"service_area":null,"event_date":null,"event_location":null}',
        'seo' => '[]',
        'advanced' => '[]',
        'subscription_plans' => '[]',
        'is_protected' => '{"own":"","user":"","other":""}',
    ];

    return [
        'name'              => $row['name'] ?? null,
        'position'          => isset($row['position']) ? (int)$row['position'] : 0,
        'parent_id'         => isset($row['parent_id']) ? (int)$row['parent_id'] : 0,
        'level'             => isset($row['level']) ? (int)$row['level'] : 0,
        'status'            => isset($row['status']) ? strtolower(trim($row['status'])) : 'active',
        'image'             => !empty($row['image']) ? $row['image'] : null,
        'icon'              => !empty($row['icon']) ? $row['icon'] : null,

        // JSON as raw string (cell value or default)
        'is_protected'      => !empty($row['is_protected']) ? $row['is_protected'] : $jsonDefaults['is_protected'],
        'label'             => $row['label'] ?? null,
        'label_json'        => !empty($row['label_json']) ? $row['label_json'] : $jsonDefaults['label_json'],
        'meta'              => !empty($row['meta']) ? $row['meta'] : $jsonDefaults['meta'],
        'display'           => !empty($row['display']) ? $row['display'] : $jsonDefaults['display'],
        'messages'          => !empty($row['messages']) ? $row['messages'] : $jsonDefaults['messages'],
        'notifications'     => !empty($row['notifications']) ? $row['notifications'] : $jsonDefaults['notifications'],
        'group_view'        => !empty($row['group_view']) ? $row['group_view'] : $jsonDefaults['group_view'],
        'price_list'        => !empty($row['price_list']) ? $row['price_list'] : $jsonDefaults['price_list'],
        'seo'               => !empty($row['seo']) ? $row['seo'] : $jsonDefaults['seo'],
        'advanced'          => !empty($row['advanced']) ? $row['advanced'] : $jsonDefaults['advanced'],
        'subscription_plans'=> !empty($row['subscription_plans']) ? $row['subscription_plans'] : $jsonDefaults['subscription_plans'],

        // Normal fields
        'code'              => $row['code'] ?? null,

        // Booleans
        'is_excluded'       => isset($row['is_excluded']) ? (int)$row['is_excluded'] : 0,
        'is_published'      => isset($row['is_published']) ? (int)$row['is_published'] : 0,
    ];
}
/**
 * ✅ Row save
 */
/*private function saveRow($rowData, $jsonDefaults, $boolFields)
{
    if (empty($rowData['name'])) {
        return; // skip blank rows
    }

    $dataToInsert = [];

    foreach ($rowData as $col => $value) {

        // Boolean fields
        if (in_array($col, $boolFields)) {
            $dataToInsert[$col] = $value == '1' ? 1 : 0;
            continue;
        }

        // JSON fields (direct string hi save karna h)
        if (array_key_exists($col, $jsonDefaults)) {
            $dataToInsert[$col] = $value ?: $jsonDefaults[$col];
            continue;
        }

        // is_protected (fixed JSON)
        if ($col === 'is_protected' || $col === 'priority') {
            $dataToInsert[$col] = $value ?: '{"own":"","user":"","other":""}';
            continue;
        }

        // Normal fields
        $dataToInsert[$col] = ($value === '' ? null : $value);
    }

    // ✅ insert into DB
    \App\Models\Category::create($dataToInsert);
}

/**
 * ✅ XLSX Reader (basic)
 */
/*
private function readXlsx($path)
{
    $zip = new \ZipArchive;
    if ($zip->open($path) === true) {
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        $sharedStrings = [];

        if ($xml !== false) {
            $dom = new \DOMDocument();
            $dom->loadXML($xml);
            foreach ($dom->getElementsByTagName('t') as $t) {
                $sharedStrings[] = $t->nodeValue;
            }
        }

        $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheet !== false) {
            $dom = new \DOMDocument();
            $dom->loadXML($sheet);
            $rows = $dom->getElementsByTagName('row');
            $data = [];

            foreach ($rows as $row) {
                $rowData = [];
                foreach ($row->getElementsByTagName('c') as $c) {
                    $v = $c->getElementsByTagName('v')->item(0)->nodeValue ?? '';
                    $type = $c->getAttribute('t');
                    if ($type === 's') {
                        $v = $sharedStrings[(int)$v] ?? $v;
                    }
                    $rowData[] = $v;
                }
                $data[] = $rowData;
            }
            return $data;
        }
    }
    return [];
}*/
/*public function importCSV(Request $request) 
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xlsx'
        ]);

        $file = $request->file('csv_file');
        $extension = strtolower($file->getClientOriginalExtension());

        // ---- Default JSON structures ----
        $jsonDefaults = [
            'meta' => [
                "meta_title" => "",
                "meta_description" => "",
                "meta_keywords" => ""
            ],
            'tooltip' =>[
                "tooltip" => "",
                "validation" => "",
                "description" => ""
            ],
            'validation' =>[
                "product_type" => null,
                "value" => null,
                "conversion_rate" => null,
                "theme" => null,
                "service_duration" => null,
                "service_area" => null,
                "event_date" => null,
                "event_location" => null
            ],
            'seo' => [],
            'advanced' => [],
            'subscription_plans' => [],
            'messages' =>[],
            'notifications' => [],
            'price_list' =>[],
            'label_json' => [],
            'display' => [],
            'group_view' => [],
        ];

        // ---- Boolean fields ----
        $boolFields = ['is_excluded','is_published','is_protected'];

        $rows = [];

        // ---- CSV / TXT ----
        if (in_array($extension, ['csv','txt'])) {
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_map('trim', array_shift($data));
            foreach ($data as $row) {
                $row = array_slice($row, 0, count($header)); 
                $row = array_pad($row, count($header), null);
                $rows[] = array_combine($header, $row);
            }
        }

        // ---- XLSX ----
        elseif ($extension === 'xlsx') {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            // first row is header
            $header = array_map('trim', array_values($data[1]));
            unset($data[1]);

            foreach ($data as $row) {
                $rowValues = array_values($row);
                $row = array_combine($header, $rowValues);
                $rows[] = $row;
            }
        }

        // ---- Process & Save Rows ----
        foreach ($rows as $row) {
            $rowData = $this->normalizeRow($row, $jsonDefaults);
            if (!empty($rowData['name'])) {
                $this->saveRow($rowData, $jsonDefaults, $boolFields);
            }
        }

        return back()->with('success', 'File imported successfully!');
    }

    /**
     * ✅ Normalize Row
     */
    /*private function normalizeRow($row, $jsonDefaults)
    {
        return [
            'name'              => $row['name'] ?? null,
            'position'          => isset($row['position']) ? (int)$row['position'] : 0,
            'parent_id'         => isset($row['parent_id']) ? (int)$row['parent_id'] : 0,
            'level'             => isset($row['level']) ? (int)$row['level'] : 0,
            'status'            => isset($row['status']) ? strtolower(trim($row['status'])) : 'active',
            'image'             => $row['image'] ?? null,
            'icon'              => $row['icon'] ?? null,

            // is_protected → sirf integer flag
            'is_protected'      => isset($row['is_protected']) ? (int)$row['is_protected'] : 0,

            'label'             => $row['label'] ?? null,
            'label_json'        => $row['label_json'] ?? $jsonDefaults['label_json'],
            'meta'              => $row['meta'] ?? $jsonDefaults['meta'],
            'display'           => $row['display'] ?? $jsonDefaults['display'],
            'messages'          => $row['messages'] ?? $jsonDefaults['messages'],
            'notifications'     => $row['notifications'] ?? $jsonDefaults['notifications'],
            'group_view'        => $row['group_view'] ?? $jsonDefaults['group_view'],
            'price_list'        => $row['price_list'] ?? $jsonDefaults['price_list'],
            'seo'               => $row['seo'] ?? $jsonDefaults['seo'],
            'advanced'          => $row['advanced'] ?? $jsonDefaults['advanced'],
            'subscription_plans'=> $row['subscription_plans'] ?? $jsonDefaults['subscription_plans'],

            'code'              => $row['code'] ?? null,

            'is_excluded'       => isset($row['is_excluded']) ? (int)$row['is_excluded'] : 0,
            'is_published'      => isset($row['is_published']) ? (int)$row['is_published'] : 0,
        ];
    }

    /**
     * ✅ Save Row
     */
    /*private function saveRow($rowData, $jsonDefaults, $boolFields)
    {
        $dataToInsert = [];

        foreach ($rowData as $col => $value) {
            // Boolean fields
            if (in_array($col, $boolFields)) {
                $dataToInsert[$col] = $value ? 1 : 0;
                continue;
            }

            // JSON fields
          if (array_key_exists($col, $jsonDefaults)) {
    $dataToInsert[$col] = $value 
        ? (is_array($value) ? json_encode($value) : $value) 
        : json_encode($jsonDefaults[$col]);
    continue;
}

            // Normal fields
            $dataToInsert[$col] = ($value === '' ? null : $value);
        }

        Category::create($dataToInsert);
    }*/


public function importCSV(Request $request) 
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt,xlsx'
    ]);

    $file = $request->file('csv_file');
    $extension = strtolower($file->getClientOriginalExtension());

    // ---- Default JSON structures ----
    $jsonDefaults = [
        'meta' => [
            "meta_title" => "",
            "meta_description" => "",
            "meta_keywords" => ""
        ],
        'tooltip' =>[
            "tooltip" => "",
            "validation" => "",
            "description" => ""
        ],
        'validation' =>[
            "product_type" => null,
            "value" => null,
            "conversion_rate" => null,
            "theme" => null,
            "service_duration" => null,
            "service_area" => null,
            "event_date" => null,
            "event_location" => null
        ],
        'seo' => [],
        'advanced' => [],
        'subscription_plans' => [],
        'messages' => [],
        'notifications' => [],
        'price_list' => [],
        'label_json' => [],
        'display' => [],
        'group_view' => [],
    ];

    // ---- Boolean fields ----
    $boolFields = ['is_excluded','is_published','is_protected'];

    $rows = [];

    // ---- CSV / TXT ----
    if (in_array($extension, ['csv','txt'])) {
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', array_shift($data));
        foreach ($data as $row) {
            $row = array_slice($row, 0, count($header)); 
            $row = array_pad($row, count($header), null);
            $rows[] = array_combine($header, $row);
        }
    }

    // ---- XLSX ----
    elseif ($extension === 'xlsx') {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true);

        // first row is header
        $header = array_map('trim', array_values($data[1]));
        unset($data[1]);

        foreach ($data as $row) {
            $rowValues = array_values($row);
            $row = array_combine($header, $rowValues);
            $rows[] = $row;
        }
    }

    // ---- Process & Save Rows ----
    foreach ($rows as $row) {
        $rowData = $this->normalizeRow($row, $jsonDefaults);
        if (!empty($rowData['name'])) {
            $this->saveRow($rowData, $jsonDefaults, $boolFields);
        }
    }

    return back()->with('success', 'File imported successfully!');
}

/**
 * ✅ Normalize Row
 */
private function normalizeRow($row, $jsonDefaults)
{
    return [
        'name'              => $row['name'] ?? null,
        'position'          => isset($row['position']) ? (int)$row['position'] : 0,
        'parent_id'         => isset($row['parent_id']) ? (int)$row['parent_id'] : 0,
        'level'             => isset($row['level']) ? (int)$row['level'] : 0,
        'status'            => isset($row['status']) ? strtolower(trim($row['status'])) : 'active',
        'image'             => $row['image'] ?? null,
        'icon'              => $row['icon'] ?? null,

        // is_protected → sirf integer flag
        'is_protected'      => isset($row['is_protected']) ? (int)$row['is_protected'] : 0,

        'label'             => $row['label'] ?? null,
        'label_json'        => $row['label_json'] ?? $jsonDefaults['label_json'],
        'meta'              => $row['meta'] ?? $jsonDefaults['meta'],
        'display'           => $row['display'] ?? $jsonDefaults['display'],
        'messages'          => $row['messages'] ?? $jsonDefaults['messages'],
        'notifications'     => $row['notifications'] ?? $jsonDefaults['notifications'],
        'group_view'        => $row['group_view'] ?? $jsonDefaults['group_view'],
        'price_list'        => $row['price_list'] ?? $jsonDefaults['price_list'],
        'seo'               => $row['seo'] ?? $jsonDefaults['seo'],
        'advanced'          => $row['advanced'] ?? $jsonDefaults['advanced'],
        'subscription_plans'=> $row['subscription_plans'] ?? $jsonDefaults['subscription_plans'],

        'code'              => $row['code'] ?? null,

        'is_excluded'       => isset($row['is_excluded']) ? (int)$row['is_excluded'] : 0,
        'is_published'      => isset($row['is_published']) ? (int)$row['is_published'] : 0,
    ];
}

/**
 * ✅ Save Row
 */
private function saveRow($rowData, $jsonDefaults, $boolFields)
{
    $dataToInsert = [];

    foreach ($rowData as $col => $value) {
        // Boolean fields
        if (in_array($col, $boolFields)) {
            $dataToInsert[$col] = $value ? 1 : 0;
            continue;
        }

        // JSON fields
        if (array_key_exists($col, $jsonDefaults)) {
            if ($value === null || $value === '' || $value === 'null' || $value === '[]' || $value === '{}') {
                $dataToInsert[$col] = null; // empty → NULL
            } else {
                if (is_array($value)) {
                    $dataToInsert[$col] = json_encode($value, JSON_UNESCAPED_UNICODE);
                } else {
                    // check if valid JSON
                    json_decode($value);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $dataToInsert[$col] = $value; // already valid JSON
                    } else {
                        $dataToInsert[$col] = json_encode([$value], JSON_UNESCAPED_UNICODE);
                    }
                }
            }
            continue;
        }

        // Normal fields
        $dataToInsert[$col] = ($value === '' ? null : $value);
    }

    Category::create($dataToInsert);
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
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\VehicleDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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



   // Show form
   /* public function create()
    {
        $productTypes = Category::whereNull('parent_id')->get();
        return view('vehicle.create', compact('productTypes'));
    }*/

    // Return subcategories or steps via AJAX
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
public function importCSV(Request $request)
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

}
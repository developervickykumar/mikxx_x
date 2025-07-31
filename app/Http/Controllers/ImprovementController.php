<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Improvement;
class ImprovementController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'items' => 'required|array',
            'items.*.type' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.priority' => 'required|string',
            'items.*.status' => 'required|string',
            'items.*.developer' => 'required|string'
        ]);
    
        foreach ($data['items'] as $item) {
            Improvement::create(array_merge($item, ['category_id' => $data['category_id']]));
        }
    
        return response()->json(['success' => true]);
    }
    
    public function index($category_id)
    {
        $improvements = Improvement::where('category_id', $category_id)->get();
        return response()->json($improvements);
    }
    
    public function update(Request $request, $id)
    {
        $improvement = Improvement::findOrFail($id);
        $improvement->update($request->only('type', 'description', 'priority', 'status', 'developer'));
        return response()->json(['success' => true]);
    }
}

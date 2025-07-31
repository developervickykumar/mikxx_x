<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureAccessTestController extends Controller
{
    public function testFormBuilder()
    {
        return response()->json(['message' => 'Form Builder access granted']);
    }

    public function testCategories()
    {
        return response()->json(['message' => 'Categories access granted']);
    }

    public function testBuilder()
    {
        return response()->json(['message' => 'Builder access granted']);
    }
} 
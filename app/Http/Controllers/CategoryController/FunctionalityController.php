<?php

namespace App\Http\Controllers\CategoryController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FunctionalityController extends Controller
{
    public function index() {
        return view('dynamic-pages.functionality.index');
    }

    public function report() {
        return view('functionality.report');
    }

    public function edit() {
        return view('functionality.edit');
    }

    public function custom() {
        return view('functionality.custom');
    }
}

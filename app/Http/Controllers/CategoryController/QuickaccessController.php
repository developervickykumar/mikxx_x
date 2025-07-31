<?php

namespace App\Http\Controllers\CategoryController;

use Illuminate\Http\Request;

class QuickAccessController extends Controller
{
    public function index() {
        return view('quick-access.index');
    }

    public function report() {
        return view('quick-access.report');
    }

    public function edit() {
        return view('quick-access.edit');
    }

    public function custom() {
        return view('quick-access.custom');
    }
}
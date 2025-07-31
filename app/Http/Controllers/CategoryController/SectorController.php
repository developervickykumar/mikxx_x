<?php

namespace App\Http\Controllers\CategoryController;

use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index() {
        return view('sector.index');
    }

    public function report() {
        return view('sector.report');
    }

    public function edit() {
        return view('sector.edit');
    }

    public function custom() {
        return view('sector.custom');
    }
}
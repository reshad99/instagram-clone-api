<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function viewDashboard(): View
    {   
        return view('admin.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function viewDashboard(): View
    {
        $categories = Category::all();
        return view('admin.index')->with([
            'Categories' => $categories,
        ]);
    }
}

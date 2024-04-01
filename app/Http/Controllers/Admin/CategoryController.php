<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Service\Admin\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService) 
    {
        $this->categoryService = $categoryService;
    }

    public function viewCategory(): View 
    {
        return view('admin.category');
    }

    public function getCategory(Category $category): View
    {
        return view('admin.update_category', [
            'category' => $category,
        ]);
    }

    public function createCategory(CategoryRequest $request): RedirectResponse
    {
        $result = $this->categoryService->createCategory($request->only('category_name'));

        if ($result['notify']) {
            return redirect()->route('admin.dashboard')->with('success', $result['message']);
        }

        return redirect()->route('admin.dashboard')->with('error', $result['message']);
    }

    public function updateCategory(Request $request) 
    {
        $result = $this->categoryService->updateCategory($request->only('category_name'));

        if ($result) {
            return redirect()->route('admin.dashboard')->with('success', 'cập nhật thành công');
        }

        return redirect()->route('admin.dashboard')->with('error', 'cập nhật thất bại');
    }
}

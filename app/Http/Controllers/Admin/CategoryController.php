<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Service\Admin\CategoryService;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(): View
    {
        return view('admin.category.create');
    }

    public function index(): View
    {
        $categories = $this->categoryService->index();
        return view('admin.category.index')->with([
            'categories' => $categories,
            'posts' => $categories,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('admin.category.update')->with([
            'category' => $category,
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $result = $this->categoryService->store($request->only('category_name'));
        if ($result) {
            return redirect()->back()->with('success', __('admin.create_category_success'));
        }
        return redirect()->back()->with('error', __('admin.create_category_error'));
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $data = $request->only('category_name');
        $result = $this->categoryService->update($data, $id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.update_category_success'));
        }
        return redirect()->back()->with('error', __('admin.update_category_error'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $result = $this->categoryService->destroy($id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.delete_category_success'));
        }
        return redirect()->back()->with('error', __('admin.delete_category_error'));
    }
}

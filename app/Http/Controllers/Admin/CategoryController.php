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

    public function store(): View
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(Category::LIMIT_ADMIN_PAGE);
        return view('admin.category.index')->with([
            'Categories' => $categories,
            'items' => $categories,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('admin.category.update', 
        ['category' => $category]);
    }

    public function post(CategoryRequest $request): RedirectResponse
    {
        $result = $this->categoryService->post($request->only('category_name'));

        if ($result) {
            return redirect()->back()->with('success', __('admin.create_category_success'));
        }

        return redirect()->back()->with('error', __('admin.create_category_error'));
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $data = $request->only('category_name');
        $data['id']= $id;
        $result = $this->categoryService->update($data);

        if ($result) {

            return redirect()->route('categories.store')->with('success', __('admin.update_category_success'));
        }

        return redirect()->route('categories.store')->with('error', __('admin.update_category_error'));
    }

    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $result = $this->categoryService->destroy($category);

        if ($result) {

            return redirect()->back()->with('success', __('admin.delete_category_success'));
        }

        return redirect()->back()->with('error', __('admin.delete_category_error'));
    }
}

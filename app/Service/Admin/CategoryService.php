<?php

namespace App\Service\Admin;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function index(): LengthAwarePaginator
    {
        $categories = Category::orderByDesc('created_at');
        if ($key = request()->key) {
            $categories->where('name', 'like', '%' . $key . '%');
        }
        return $categories->paginate(config('length.limit_page_admin'));
    }

    public function store(array $data): Category
    {
        try {
            return Category::create([
                'name' => $data['category_name'],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function update(array $data, int $id): bool
    {
        try {
            $category = Category::findOrFail($id);
            return $category->update([
                'name' => $data['category_name']
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $category = Category::findOrFail($id);
            $category->posts()->detach();
            return $category->delete();
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getAll(): Collection
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}

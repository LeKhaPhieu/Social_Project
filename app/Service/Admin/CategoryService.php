<?php

namespace App\Service\Admin;

use App\Models\Category;
use Exception;

class CategoryService
{
    public function post(array $data): bool
    {
        try {
            Category::create([
                'name' => $data['category_name'],
            ]);
    
            return true;

        } catch (Exception $e) {

            return false;
        }
    }

    public function update(array $data): bool
    {
        try {
            $category = Category::findOrFail($data['id']);
            $category->update([
                'name' => $data['category_name']
            ]);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function destroy(Category $category): bool
    {
        try {
            $category->delete();

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}

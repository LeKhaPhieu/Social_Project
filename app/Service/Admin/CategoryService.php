<?php

namespace App\Service\Admin;

use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    public function createCategory(array $data): array
    {
        $user = Auth::user();
        if ($user->role == User::ROLE_ADMIN) {
            Category::create([
                'name' => $data['category_name'],
            ]);

            return [
                'notify' => true,
                'message' => 'Create category successfully',
            ];
        }

        return [
            'notify' => false,
            'message' => 'Unable to create category, please try again!',
        ];
    }

    public function updateCategory(array $data): bool
    {
        try {
            $user = Auth::user();
            if ($user->role == User::ROLE_ADMIN) {
                $category = Category::find($data['id']);
                $category->name = $data['category_name'];
                $category->save();

                return true;
            } else {

                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteCategory(Category $category): bool
    {
        try {
            $category->delete();

            return true;
        } catch (Exception $e) {
            
            return false;
        }
    }
}

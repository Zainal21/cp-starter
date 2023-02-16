<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;

interface CategoryContract
{
    public function getCategoryById($id);
    public function deleteCategory($id);
    public function updateCategory($data, $id);
}

class CategoryRepository implements CategoryContract
{
    public function getCategories()
    {
        return Category::latest()->get();
    }

    public function getCategoryById($id)
    {
        return Category::findOrfail($id);
    }

    public function deleteCategory($id)
    {
        return Category::destroy($id);
    }

    public function createCategory($data)
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);
    }

    public function updateCategory($data, $id)
    {
        return Category::where('id', $id)->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);
    }
}
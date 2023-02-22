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
    /**
     * Query for get latest category
     * 
     * @param null
     * 
     * @return Collection service that was find.
     */
    public function getCategories()
    {
        return Category::latest()->get();
    }
    /**
     * Query for get category item by id
     * 
     * @param id request The request string
     * 
     * @return The service that was store.
     */
    public function getCategoryById($id)
    {
        return Category::findOrfail($id);
    }
    /**
     * Query for delete category item by id
     * 
     * @param Request request The request object
     * 
     * @return The service that was deleted.
     */
    public function deleteCategory($id)
    {
        return Category::destroy($id);
    }
    /**
     * Query for create a new category
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createCategory($data)
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);
    }
    /**
     * Query for update category data by Id
     * 
     * @param Request request The request object
     * @param id request The request string
     * @return The service that was updated.
     */
    public function updateCategory($data, $id)
    {
        return Category::where('id', $id)->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);
    }
}
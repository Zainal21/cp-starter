<?php

namespace App\Services;

use DataTables;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    private $categoryRepository; 

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    } 
    /**
     * service for show datatable category
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getCategories()
    {
        $categories = $this->categoryRepository->getCategories();
        return DataTables::of($categories)
        ->addColumn('action', function($row){
            $actionBtn = '-';
            $actionBtn = '<button  class="edit btn btn-success btn-sm mx-2" onClick="showDetailCategory(`'.$row->id.'`)">Edit</button>';
            $actionBtn .= '<button onClick="deleteCategory(`'.$row->id.'`)" class="delete btn btn-danger btn-sm text-white mx-2">Delete</button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
    /**
     * service for get latest category
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getLatestCategory()
    {
        return $this->categoryRepository->getCategories();
    }
    /**
     * service for get category by id
     * 
     * @param Id request The request id
     * 
     * @return The service that was find.
     */
    public function getCategoryById($id)
    {
        $category = $this->categoryRepository->getCategoryById($id);
        if(!$category) return ResponseHelper::error('Data Kategori tidak ditemukan', null, 404);
        return ResponseHelper::success($category, 'Data Kategori Berhasil ditemukan');
    }
    /**
     * service for create category
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createCategory($request)
    {
        $schema = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ]);

        if($schema->fails()){
            return ResponseHelper::error($schema->errors());
        }else{
            $created = $this->categoryRepository->createCategory($request->all());
            if(!$created) return ResponseHelper::error('Data Kategori gagal ditambahkan', null, 404);
            return ResponseHelper::success($created, 'Data Kategori Berhasil ditambahkan');
        }
    }
    /**
     * service for update category by id
     * 
     * @param Id request The request string
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function updateCategory($request, $id)
    {
        $schema = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if($schema->fails()){
            return ResponseHelper::error($schema->errors());
        }else{
            $updated = $this->categoryRepository->updateCategory($request->all(), $id);
            if(!$updated) return ResponseHelper::error('Data Kategori tidak ditemukan', null, 404);
            return ResponseHelper::success($updated, 'Data Kategori Berhasil diperbarui');
        }
    }
    /**
     * service for delete category
     * 
     * @param Category request The request collection
     * 
     * @return The service that was deleted.
     */
    public function deleteCategory($category)
    {
        if($category->post()->count()){
            return ResponseHelper::error('Data Kategori, Saat ini belum dapat dihapus, Dikarenakan terdapat artikel dari kategori tersebut yang belum terhapus');
        }       
        $deleted = $this->categoryRepository->deleteCategory($category->id);
        if(!$deleted) return ResponseHelper::error('Data Kategori tidak ditemukan', null, 404);
        return ResponseHelper::success($deleted, 'Data Kategori Berhasil dihapus');
    }

}
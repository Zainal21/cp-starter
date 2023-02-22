<?php

namespace App\Services;

use DataTables;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Crypt;


class RoleService
{
    private $roleRepository; 

    public function __construct()
    {
        $this->roleRepository = new RoleRepository();
    }
    /**
     * service to get datatables all roles
     * 
     * @return The service that was find.
     */
    public function getDatatable()
    {
        $roles = $this->roleRepository->getAllRoles();
        return DataTables::of($roles)
        ->addColumn('action', function($row){
            $actionBtn = '-';
            $actionBtn = ' <a href="'.route('roles.show', Crypt::encrypt($row->id)).'" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="fas fa-eye"></i></a>';
            $actionBtn .= ' <a href="'.route('roles.edit', Crypt::encrypt($row->id)).'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fas fa-edit"></i></a>';
            $actionBtn .= ' <button onclick="deleteRole(`'. Crypt::encrypt($row->id).'`)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data"><i class="fas fa-trash"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
    /**
     * service to get role permission by id
     * 
     * @param Id request The request inteher
     * 
     * @return The service that was store.
     */
    public function getRoleUserPermission($id)
    {
        try {
            $role = $this->roleRepository->getRoleUserPermission($id);
            return $role;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * service to update role permission
     * 
     * @param Request request The request object
     * @param id request The request integer
     * 
     * @return The service that was updated.
     */
    public function updateUserRole($request, $id)
    {
        try {
            $role = $this->roleRepository->getRoleById($id);
            $role->name = $request['name'];
            $role->save();
            $role->syncPermissions($request['permission']);
            return ResponseHelper::success(1, 'Hak akses pengguna berhasil di-perbarui');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to get role by id
     * 
     * @param Id request The request Integer
     * 
     * @return The service that was find.
     */
    public function getRoleById($id)
    {
        try {
            $role = $this->roleRepository->getRoleById($id);
            return $role;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * service to all roles
     * 
     * @return The service that was find.
     */
    public function getAllRoles()
    {
        try {
            return $this->roleRepository->getAllRoles();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * service to all permission
     * 
     * @return The service that was find.
     */
    public function getAllPermission()
    {
        try {
            return $this->roleRepository->getAllPermission();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * service to create new role
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createNewRole($request)
    {
        try {
            $data = [
                'name' => $request['name']
            ];
            $role =  $this->roleRepository->createNewRole($data);
            $role->syncPermissions($request['permission']);
            return ResponseHelper::success(1, 'Hak akses pengguna berhasil di-tambahkan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to delete role
     * 
     * @param Request request The request object
     * 
     * @return The service that was deleted.
     */
    public function deleteRole($id)
    {
        try {
            $deleted =  $this->roleRepository->deletePermissions($id);
            if(!$deleted) return ResponseHelper::error('Data Role tidak ditemukan', null, 404);
            return ResponseHelper::success($deleted, 'Data Role Berhasil ditemukan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data', null, 404);
        }
    }
}
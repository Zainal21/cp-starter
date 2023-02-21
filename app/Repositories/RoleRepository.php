<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

interface RoleContract
{
    public function getAllRoles();
    public function getAllPermission();
    public function createNewRole($data);
    public function getRoleById($id);
    public function deletePermissions($id);
    public function getRoleUserPermission($id);
}

class RoleRepository implements RoleContract
{
    public function getAllRoles()
    {
      return Role::latest()->get();
    }

    public function getAllPermission()
    {
        return Permission::get();
    }

    public function createNewRole($data)
    {
        return Role::create($data);
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function deletePermissions($id)
    {
        return Role::destroy($id);
    }

    public function getRoleUserPermission($id)
    { 
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    }
}
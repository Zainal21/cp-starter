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
    /**
     * Query for get all roles
     * 
     * @return The service that was find.
     */
    public function getAllRoles()
    {
      return Role::latest()->get();
    }
    /**
     * Query for get all permission
     * 
     * @return The service that was find.
     */
    public function getAllPermission()
    {
        return Permission::get();
    }
    /**
     * Query for create new role
     * 
     * @param Data request The request object
     * 
     * @return The service that was store.
     */
    public function createNewRole($data)
    {
        return Role::create($data);
    }
    /**
     * Query for get role by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was find.
     */
    public function getRoleById($id)
    {
        return Role::find($id);
    }
    /**
     * Query for delete role permission by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deletePermissions($id)
    {
        return Role::destroy($id);
    }
    /**
     * Query for get user role & permission
     * 
     * @param Id request The request string
     * 
     * @return The service that was find.
     */
    public function getRoleUserPermission($id)
    { 
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    }
}
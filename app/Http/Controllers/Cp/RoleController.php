<?php

namespace App\Http\Controllers\Cp;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $roleService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->roleService =  new RoleService();;
    }

    public function getDatatable()
    {
        return $this->roleService->getDatatable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('cp.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = $this->roleService->getAllPermission();
        return view('cp.roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        return $this->roleService->createNewRole($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_encrypt = Crypt::Decrypt($id);
        $role = $this->roleService->getRoleById($id_encrypt);
        $permission = $this->roleService->getAllPermission();
        $rolePermissions = $this->roleService->getRoleUserPermission($id_encrypt);
        return view('cp.roles.show',compact('role','rolePermissions', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_encrypt = Crypt::Decrypt($id);
        $role = $this->roleService->getRoleById($id_encrypt);
        $permission = $this->roleService->getAllPermission();
        $rolePermissions = $this->roleService->getRoleUserPermission($id_encrypt);
        return view('cp.roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        return $this->roleService->updateUserRole($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id_encrypt = Crypt::Decrypt($id);
        return $this->roleService->deleteRole($id_encrypt);
    }
}

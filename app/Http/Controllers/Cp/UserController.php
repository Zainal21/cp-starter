<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('cp.users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('cp.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt('!AdminLaravel12345')
        ]);
        $user->assignRole($request->input('roles'));
        Helper::printlog('Menambahkan Data Pengguna Baru');
        return redirect()->route('users.index')
                        ->with('success','Data Pengguna baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail(Crypt::decrypt($id));
        $roles = Role::get();
        return view('cp.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['roles' => 'required']);
        $user = User::findOrfail($id);
        $userRole = $user->getRoleNames();
        $user->removeRole($userRole[0]);
        $user->assignRole($request->input('roles'));
        Helper::printlog('Mengubah role pengguna');
        return redirect()->route('users.index')
                        ->with('success','Data Pengguna berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->post()->count()){
            return redirect()->back()->with('error', 'Data User, Saat ini belum dapat dihapus, Dikarenakan terdapat artikel dari user tersebut yang belum dihapus');
        }
        User::find($user->id)->delete();
        Helper::printlog('Menghapus Pengguna Dengan ID ' . $user->id . ' Dari Database');
        return redirect()->route('users.index')
                        ->with('success','Data penguna berhasil dihapus');
    }
}

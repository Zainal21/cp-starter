<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Validator;


class ProfileService
{
    private $profileRepository; 

    public function __construct()
    {
        $this->profileRepository = new ProfileRepository();
    }

    public function getUserProfile($id)
    {
        $user = $this->profileRepository->getUserById($id);
        if(!$user) return redirect()->back();
        return view('cp.user_profile.profile', compact('user'));
    }

    public function getUserChangePassword()
    {
        $id = auth()->user()->id;
        $user = $this->profileRepository->getUserById($id);
        return view('cp.user_profile.password', compact('user'));
    }

    public function changeUserPassword($request, $id)
    {
        $user = $this->profileRepository->getUserById($id);
        if (Hash::check($request['currentPassword'] , $user->password)){
            $user->update([
                'password' => Hash::make($request['new_password']),
            ]);
            return ResponseHelper::success(1, 'Password Berhasil diperbarui');
        } else {
            return ResponseHelper::error('Password gagal diperbarui');
        }
    }

    public function changeUserProfile($request, $id)
    {
        $user = $this->profileRepository->getUserById($id);
        if ($request->username === $user->username) {
            $is_valid_user_name = 'required';
        }else {
            $is_valid_user_name = 'required|unique:users,username';
        }
        if ($request->email === $user->email) {
            $is_valid_email = 'required';
        }else {
            $is_valid_email = 'required|unique:users,email';
        }

        $schema = Validator::make($request->all(), [
            'name' => 'required',
            'username' => $is_valid_user_name,
            'email' => $is_valid_email,
            'password' => 'required',
        ]);
        if($schema->fails()){
            return ResponseHelper::error($schema->errors());
        }else{
            if (Hash::check($request->password , $user->password )){
                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                ]);
                return ResponseHelper::success(1, 'Profil Pengguna Berhasil diperbarui');
            } else {
                return ResponseHelper::error('Profil Pengguna Gagal diperbarui');
            }
        }
    }

}
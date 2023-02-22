<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
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
    /**
     * Service to change user profile
     * 
     * @param Id request The request string
     * 
     * @return The service that was store.
     */
    public function getUserProfile($id)
    {
        try {
            $user = $this->profileRepository->getUserById($id);
            return $user;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * Service to change user password
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getUserChangePassword($id)
    {
        try {
            $user = $this->profileRepository->getUserById($id);
            return $user;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * Service to change user password
     * 
     * @param Request request The request object
     * @param Id request The request integer
     * 
     * @return The service that was store.
     */
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
    /**
     * Service to change user profile data
     * 
     * @param Request request The request object
     * @param Id request The request string
     * 
     * @return The service that was store.
     */
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
<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }
    /**
     * service to get all users
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getUsers()
    {
        try {
            $users = $this->userRepository->getUsers();
            return $users;
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');;
            throw abort(500);
        }
    }
    /**
     * service to get all roles
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getRoles()
    {
        try {
            $roles = $this->userRepository->getRoles();
            return $roles;
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');;
            throw abort(500);
        }
    }
    /**
     * service to create new user
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createNewuser($request)
    {
        try {
            $data = [
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => bcrypt('!AdminLaravel12345')
            ];
           $user =  $this->userRepository->createNewUser($data);
           $user->assignRole($request['roles']);
           return ResponseHelper::success(1, 'Data User Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to get detail users
     * 
     * @param id request The request string
     * 
     * @return The service that was find.
     */
    public function getDetailUser($id)
    {
        try {
           $user = $this->userRepository->getUserById($id);
           return ResponseHelper::success($user, 'Data User Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to update user role
     * 
     * @param Request request The request object and string
     * 
     * @return The service that was updated.
     */
    public function updateUserRole($request, $id)
    {
        try {
            $user = $this->userRepository->getUserById($id);
            $userRole = $user->getRoleNames();
            $user->removeRole($userRole[0]);
            $user->assignRole($request['roles']);
            return ResponseHelper::success(1, 'Role User Berhasil diperbarui');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to delete user
     * 
     * @param id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deleteUser($id)
    {
        try {
            $user = $this->userRepository->getUserById($id);
            if($user->post()->count()){
                return ResponseHelper::error($th->getMessage() ?? 'Data User, Saat ini belum dapat dihapus, Dikarenakan terdapat artikel dari user tersebut yang belum dihapus');
            }
            $this->userRepository->deleteUsers($id);
            return ResponseHelper::success(1, 'Data User Berhasil dihapus');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
}
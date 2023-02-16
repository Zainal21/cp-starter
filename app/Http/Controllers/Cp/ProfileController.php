<?php

namespace App\Http\Controllers\Cp;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ProfileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\changePasswordRequest;

class ProfileController extends Controller
{
    private $profileService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->profileService = new ProfileService;
    }
    
    public function profile($id)
    {
        return $this->profileService->getUserProfile($id);
    }

    public function changeProfile(Request $request, $id)
    {
       return $this->profileService->changeUserProfile($request,$id);
    }

    public function password()
    {
      return $this->profileService->getUserChangePassword();
    }

    public function changePassword(changePasswordRequest $request, $id)
    {
       return $this->profileService->changeUserPassword($request->all(), $id);
    }
}

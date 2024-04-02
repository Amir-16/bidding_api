<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegisterRequest;
use App\Models\User;
use App\Traits\ApiManage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiManage;

    public function register(UserRegisterRequest $request)
    {
        try {
            User::create([
                'email' => $request->email,
                'name' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);

            return $this->apiResponse(1, 'User created successfully');
        } catch (Exception $e) {

            return $this->apiResponse(0, $e->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = User::find(Auth::user()->id);
            $data['token'] = $user->createToken($user->email)->plainTextToken;

            return $this->apiResponse(1, 'Successfully Logged In ', $data);
        } else {

            return $this->apiResponse(0, 'User Login failed');
        }
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        Auth::guard('user')->logout();

        return $this->apiResponse(1, 'Successfully Logged Out');
    }
}

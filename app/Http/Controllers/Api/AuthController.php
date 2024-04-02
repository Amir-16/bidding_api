<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegisterRequest;
use App\Models\User;
use App\Traits\ApiManage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiManage;

    public function register(UserRegisterRequest $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);

            return $this->successResponse($user, 'User created successfully');
        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = User::find(Auth::user()->id);
            $data['token'] = $user->createToken($user->email)->plainTextToken;

            return $this->successResponse($data, 'Successfully Logged In ');
        } else {

            return $this->errorResponse('User Login failed');
        }
    }
}

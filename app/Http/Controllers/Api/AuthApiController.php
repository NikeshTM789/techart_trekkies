<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthApiController extends Controller
{
    public function register(UserRegisterRequest $request){
        $token = User::create($request->validated())->getAuthToken();
        return Response::successJson('User Registered', compact('token'));
    }

    public function login(UserLoginRequest $request){
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->getAuthToken();
            return Response::successJson('User Logged In', compact('token'));
        }
        return Response::errorJson('Credentials Does Not Match');
    }
}

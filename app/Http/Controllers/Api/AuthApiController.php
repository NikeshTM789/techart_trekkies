<?php

namespace App\Http\Controllers\Api;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AuthApiController extends Controller
{
    public function register(UserRegisterRequest $request){
        $token = null;
        DB::transaction(function () use($request){
            $user = User::create($request->validated());
            $user->assignRole(RoleEnum::USER->value);
            $token = $user->getAuthToken();
        });
        return Response::successJson('User Registered', compact('token'));
    }

    public function login(UserLoginRequest $request){
        $flag = false;
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $flag = true;
        }elseif (Auth::guard('agent')->attempt($request->validated())) {
            $user = Auth::guard('agent')->user();
            $flag = true;
        }
        if ($flag) {
            $token = $user->getAuthToken();
            return Response::successJson('Logged In', compact('token'));
        }
        return Response::errorJson('Credentials Does Not Match');
    }
}

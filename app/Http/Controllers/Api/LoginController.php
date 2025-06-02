<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            // 'id' => 'required|exists:vendors,id',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        // auth attempt 
        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            if ($user->status == "Inactive") {
                return response()->json([
                    'success' => 0,
                    'message' => 'Your account is inactive',
                ], 422);
            }
            // $user->api_token =  Str::random(80);
            // genetaye only if if api token doesnt exist 
            if (!$user->api_token) {
                $user->api_token = Str::random(80);
            }
            $user->active_login =  1;
            $user->save();
            /// add thes field in data array 'api_token' => $user->api_token,
            // "name" => $user->name,
            // "email" => $user->email,
            // "id" => $user->id,

            $data = [
                'api_token' => $user->api_token,
                "name" => $user->name,
                "email" => $user->email,
                "id" => $user->id,
            ];

            return response()->json([
                'success' => 1,
                'message' => 'Login SuccessFul',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Login credentials ',
            ], 422);
        }
    }
    public function logout(Request $request)
    {
        $user = User::find($request->id);
        $user->active_login = 0;
        $user->save();
        return response()->json([
            'success' => 1,
            'message' => 'Logout SuccessFul',
        ]);
    }
}

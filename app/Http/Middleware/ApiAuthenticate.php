<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required',
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $user=User::find($request->input('id'));
        if (!$user) {
            return response()->json(['message' => 'User not found','success'=>'0'], 404);
        }
        if ($user->api_token !== $request->input('api_token')) {
            return response()->json(['message' => 'Unauthorized','success'=>'0'], 401);
        }
        if ($user->status == "Inactive") {
            return response()->json(['message' =>'Your Account Is Inactive','success'=>'0'], 401);
        }
        return $next($request);
    }
}

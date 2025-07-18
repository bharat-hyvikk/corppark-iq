<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.signin');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
        );
        $credentials = $request->only('email', 'password');

        $rememberMe = $request->rememberMe ? true : false;
        if (Auth::attempt($credentials, $rememberMe)) {
            // Authentication passed...
            if (Auth::user()->user_type == 0) {
                // Invalid user type, logout
                Auth::logout();
                return redirect()->back()->withErrors(['message' => 'You can not use this portal.']);
            } else {
                // Continue login (valid user)
                return redirect()->intended('dashboard');
            }
        }
        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store( Request $request )
    {
        if( !Auth::attempt( $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]), true) ){
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing');
    }    

    public function destroy( Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended('/');
    }    
}

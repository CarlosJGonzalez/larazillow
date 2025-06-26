<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAccountController
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store( Request $request )
    {
        //using make, $user->save() is required
        $user = User::create(
                $request->validate([
                    'name'  => 'required|string|min:6',
                    'email' => 'required|email|unique:users',
                    'password'  => 'required|string|min:6|confirmed'
                ])
            );
        Auth::login( $user );
        
        return redirect()->route('listing.index')
            ->with('success', 'Account created!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show form to create new session
    public function create()
    {
        return inertia('Auth/Login');
    }
    // Store new session (sign in user)
    public function store(Request $request)
    {
        // attempt returns true if authentication is successful or false if it fails
        if (!Auth::attempt($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
            // true - remember me until logout
        ]), true)) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function destroy()
    {
    }
}

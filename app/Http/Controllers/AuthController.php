<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Show Login Form
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store()
    {
    }

    public function destroy()
    {
    }
}

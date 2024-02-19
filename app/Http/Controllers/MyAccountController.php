<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function index()
    {
        // dd(Auth::user()->listings);
        // Fetch the authenticated user's listings
        return inertia('MyAccount/Index',
        ['listings' => Auth::user()->listings]);
    }
}

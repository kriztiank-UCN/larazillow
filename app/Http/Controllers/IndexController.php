<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {   
        // dd(Listing::all());
        // dd(Auth::User());
        return inertia('Index/Index', [
            'msg' => 'Hello, World!'
        ]);
    }

    public function show()
    {
        return inertia('Index/Show');
    }
}

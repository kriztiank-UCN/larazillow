<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;

// create a new route, a new controller method and a new view for each resource

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing in database
// edit - Show form to edit listing
// update - Update listing in database
// destroy - Delete listing in database

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);

Route::resource('listing', ListingController::class);

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;

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
Route::get('/hello', [IndexController::class, 'show'])->middleware('auth');

Route::resource('listing', ListingController::class);
  // ->only(['create', 'store', 'edit', 'update', 'destroy'])
  // ->middleware('auth');

// Remaining routes are public, or use a __construct() method to apply middleware in the ListingController
// Route::resource('listing', ListingController::class)
//   ->except(['create', 'store', 'edit', 'update', 'destroy']);


Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)
  ->only(['create']);

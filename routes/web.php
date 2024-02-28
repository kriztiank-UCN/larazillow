<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MyAccountController;
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
// Route::get('/hello', [IndexController::class, 'show'])->middleware('auth');

// public routes
Route::resource('listing', ListingController::class)
  ->only(['index', 'show']);
// login/logout
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');
// register
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);
// authenticated routes
Route::prefix('my-account')
  ->name('my-account.')
  ->middleware('auth')
  ->group(function () {
    Route::name('listing.restore')->put(
      'listing/{listing}/restore',
      [MyAccountController::class, 'restore']
    )->withTrashed();

    Route::resource('listing', MyAccountController::class)->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])->withTrashed();

    Route::resource('listing.image', ImageController::class)->only(['create', 'store', 'destroy']);

  });

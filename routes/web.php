<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\MyAccountAcceptOfferController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::resource('listing', ListingController::class)
  ->only(['index', 'show']);

Route::resource('listing.offer', ListingOfferController::class)
  ->middleware('auth')
  ->only(['store']);

// notifications
Route::resource('notification', NotificationController::class)
  ->middleware('auth')
  ->only(['index']);

Route::put(
  'notification/{notification}/seen',
  NotificationSeenController::class
)->middleware('auth')->name('notification.seen');

// login/logout
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

// register
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);

// emal verification  
Route::get('/email/verify', function () {
  return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

// https://laravel.com/docs/10.x/verification#the-email-verification-handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();

  return redirect()->route('listing.index')
    ->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// https://laravel.com/docs/10.x/verification#resending-the-verification-email
Route::post('/email/verification-notification', function (Request $request) {
  $request->user()->sendEmailVerificationNotification();

  return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// my-account
Route::prefix('my-account')
  ->name('my-account.')
  // ->middleware('auth')
  ->middleware(['auth', 'verified'])
  ->group(function () {
    Route::name('listing.restore')->put(
      'listing/{listing}/restore',
      [MyAccountController::class, 'restore']
    )->withTrashed();

    // Complete set of resource routes
    Route::resource('listing', MyAccountController::class)
      // ->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
      ->withTrashed();

    // Single Action Controller
    Route::name('offer.accept')
      ->put(
        'offer/{offer}/accept',
        MyAccountAcceptOfferController::class
      );

    Route::resource('listing.image', ImageController::class)->only(['create', 'store', 'destroy']);
  });

<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show']);
        // third way of authorizing the user, authorization rules are in the ListingPolicy.php
        $this->authorizeResource(Listing::class, 'listing');
    }
    public function index()
    {
        // dd(Auth::user()->listings);
        // Fetch the authenticated user's listings
        return inertia('MyAccount/Index',
        ['listings' => Auth::user()->listings]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Listing was deleted!');
    }
}

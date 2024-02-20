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
    public function index(Request $request)
    {
        // dd($request->boolean('deleted'));
        $filters = [
            'deleted' => $request->boolean('deleted'),
            // ...$request works like array_merge
            ...$request->only(['by', 'order'])
        ];

        // dd(Auth::user()->listings);
        // Fetch the authenticated user's listings
        return inertia(
            'MyAccount/Index',
            [   // pass the filters and the listings to the view
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
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

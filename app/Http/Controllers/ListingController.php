<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Auth;
use Illuminate\Http\Request;

// Common Resources:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing in database
// edit - Show form to edit listing
// update - Update listing in database
// destroy - Delete listing in database

class ListingController extends Controller
{
    public function __construct()
    {
        // third way of authorizing the user, authorization rules are in the ListingPolicy.php
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   // -- #1 filters in the controller
        // $filters = $request->only([
        //     'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        // ]);
        // $query = Listing::orderByDesc('created_at');

        // if ($filters['priceFrom'] ?? false) {
        //     $query->where('price', '>=', $filters['priceFrom']);
        // }

        // if ($filters['priceTo'] ?? false) {
        //     $query->where('price', '<=', $filters['priceTo']);
        // }

        // if ($filters['beds'] ?? false) {
        //     $query->where('beds', $filters['beds']);
        // }

        // if ($filters['baths'] ?? false) {
        //     $query->where('baths', $filters['baths']);
        // }

        // if ($filters['areaFrom'] ?? false) {
        //     $query->where('area', '>=', $filters['areaFrom']);
        // }

        // if ($filters['areaTo'] ?? false) {
        //     $query->where('area', '<=', $filters['areaTo']);
        // }

        // return inertia(
        //     'Listing/Index',
        //     [
        //         'filters' => $filters,
        //         'listings' => $query
        //             ->paginate(10)
        //             ->withQueryString()
        //     ]
        // );

        // -- #2 scopeFilter in the model
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->paginate(10)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        // two ways of authorizing the user, return true or false in the ListingPolicy
        // #1
        // if (Auth::user()->cannot('view', $listing)) {
        //     abort(403, 'You are not allowed to view this listing!');
        // }
        // #2
        // $this->authorize('view', $listing);

        // load the images relationship, all the related images.
        $listing->load(['images']);
        // Get the offer made by the authenticated user
        $offer = !Auth::user() ?
            null : $listing->offers()->byMe()->first();

        return inertia('Listing/Show', [
            // Pass the data as props in an listing variable
            'listing' => $listing,
            // Pass the data as props in an offerMade variable
            'offerMade' => $offer
        ]);
    }
}

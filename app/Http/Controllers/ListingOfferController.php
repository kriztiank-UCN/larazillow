<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        // storing new offer that's associated with the current user to the listing model 
        $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:20000000'
                ])
            )->bidder()->associate($request->user())
        );

        return redirect()->back()->with(
            'success',
            'Offer was made!'
        );
    }
}

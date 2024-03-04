<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Notifications\OfferMade;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        // Call the view policy method with the current user, which means you will be only able to submit an offer if the listing is not sold.
        $this->authorize('view', $listing);
        // Storing new offer that's associated with the current user on the listing model and save it in an $offer variable. 
        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:20000000'
                ])
            )->bidder()->associate($request->user())
        );

        // Notify the listing owner about the new offer.
        $listing->owner->notify(new OfferMade($offer));


        return redirect()->back()->with(
            'success',
            'Offer was made!'
        );
    }
}

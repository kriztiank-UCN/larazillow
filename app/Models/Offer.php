<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    public function listing(): BelongsTo
    {
        // Offer belongs to a listing
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function bidder(): BelongsTo
    {
        // Offer belongs to a bidder
        return $this->belongsTo(User::class, 'bidder_id');
    }
    // Scopes allow developers to add constraints to queries for a given model.
    // Local Scope Method
    // TODO watch scope videos again???
    // get the bidder_id from the authenticated user
    // get all the offers by the authenticated user, used in ListingController.php as byMe()
    public function scopeByMe(Builder $query): Builder
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }
    // 146.Accepting Offers (Single Action Controller & Loading Nested Relations)
    // get all the offers except a specific offer, used in MyAccountAcceptOfferController.php as except()
    public function scopeExcept(Builder $query, Offer $offer): Builder
    {
        return $query->where('id', '!=', $offer->id);
    }
}

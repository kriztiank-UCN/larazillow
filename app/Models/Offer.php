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
    // Local Scope Method
    public function scopeByMe(Builder $query): Builder
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }
}
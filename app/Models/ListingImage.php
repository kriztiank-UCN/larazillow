<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    // An image belongs to a listing, and a listing can have many images
    // Laravel has a mechanism to automatically figure out the column name to use for the foreign key.
    // In this case, the function name is listing, so Laravel will use listing_id as the foreign key.
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}

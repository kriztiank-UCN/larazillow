<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{

    public function before(?User $user, $ability)
    {
        if ($user?->is_admin /*&& $ability === 'update'*/) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     * The ViewAny action is mapped to our controller index action.
     */
    // ?User means that the user can be null
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * The View action is mapped to our controller show action.
     */
    public function view(?User $user, Listing $listing): bool
    {
        // let's make sure that the user that's currently logged in is the owner of this listing.
        // user? by adding this question mark, we are making sure that we will only read the property of this object if this is indeed an object, not an NULL value.
        // So if the by_user_id is identical to the current user ID, we just return trrue, means you can see this listing.
        if ($listing->by_user_id === $user?->id) {
            return true;
        }

        // if a listing is not sold, we can see it and make offers.
        return $listing->sold_at === null;
    }

    /**
     * Determine whether the user can create models.
     * The Create action is mapped to our controller create action.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * The Update action is mapped to our controller update action.
     */
    public function update(User $user, Listing $listing): bool
    {
        // if the listing is not sold and the user is the owner of the listing, then we can update the listing.
        return $listing->sold_at === null
        && ($user->id === $listing->by_user_id);
    }

    /**
     * Determine whether the user can delete the model.
     * The Delete action is mapped to our controller destroy action.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * The Restore action is mapped to our controller restore action. 
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * The ForceDelete action is mapped to our controller forceDelete action.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }
}

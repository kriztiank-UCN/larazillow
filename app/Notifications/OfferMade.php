<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * 
     */

     // private Offer $offer is a shorthand syntax to define a field in a class and initialize it through the constructor.
     // So now this class has a private field called offer of the type Offer, which is the Offer model.
    public function __construct(private Offer $offer)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line("New offer ({$this->offer->amount}) was made for your listing")
        ->action(
            'See Your Listing',
            route('my-account.listing.show', ['listing' => $this->offer->listing_id])
        )
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // This method is important. It contains all the information that would be stored along the notification in the database.
    public function toArray(object $notifiable): array
    {
        return [
            'offer_id' => $this->offer->id,
            'listing_id' => $this->offer->listing_id,
            'amount' => $this->offer->amount,
            'bidder_id' => $this->offer->bidder_id
        ];
    }
}

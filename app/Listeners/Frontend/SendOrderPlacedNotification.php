<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\OrderPlaced;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderPlacedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $user = $event->user;
        $order = $event->order;

        // Create Log
        Log::info('New Order Placed with id ');

        // Send Email To Registered User
        try {
            $user->notify(new OrderPlacedNotification($order));
        } catch (\Exception $e) {
            Log::error('OrderPlacedListener: Email Send Failed.');
            Log::error($e);
        }
    }
}

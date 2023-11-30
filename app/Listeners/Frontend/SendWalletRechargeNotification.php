<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\WalletRecharge;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\WalletRechargeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWalletRechargeNotification
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
    public function handle(WalletRecharge $event): void
    {
        $user = $event->user;
        $transaction = $event->transaction;

        // Create Log
        Log::info('New Order Placed with id ');

        // Send Email To Registered User
        try {
            $delay = now()->addMinutes(10);
            $user->notify((new WalletRechargeNotification($transaction))->delay($delay));
        } catch (\Exception $e) {
            Log::error('OrderPlacedListener: Email Send Failed.');
            Log::error($e);
        }
    }
}

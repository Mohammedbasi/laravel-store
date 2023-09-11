<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {

        $order = $event->order;

        // The case of single user to notify
        $user = User::where('store_id', '=', $order->store_id)->first();
        if ($user) {
            $user->notify(new OrderCreatedNotification($order));
        }
        // The case of multi users to notify
        /*
        $users = User::where('store_id', '=', $order->store_id)->get();
        Notification::send(new OrderCreatedNotification($order));
        */
    }
}

<?php

namespace Armincms\Coursera\Listeners;

use Armincms\Orderable\Events\OrderVerified;

class Order
{
    /**
     * Check new order for subscriptions.
     */
    public function handleSubscription($event) {
        if ($event->order->resource !== 'Armincms\\Coursera\\Nova\\Course') {
            // prevent to subscribe for another orders.
            return;
        }

        $event->order->loadMissing('items.salable')->items->each(function($item) {
            $item->salable->subscribe(data_get($item, 'detail.user'));
        });
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        return [
            OrderVerified::class => 'handleSubscription',
        ];
    }
}
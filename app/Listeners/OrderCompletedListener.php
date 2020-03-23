<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Mail\OrderCompleted;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Class OrderCompletedListener
 * @package App\Listeners
 */
class OrderCompletedListener
{
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->getOrder();

        /** @var Collection $toEmails */
        $toEmails = $order->products->map(function($item){
            return $item->product->vendor->email;
        });
        $toEmails->push($order->client_email);
        Mail::to($toEmails)->send(new OrderCompleted($event->getOrder()));
    }

}
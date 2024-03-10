<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Services\Contracts\QuoteInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
{
    /**
     * QuoteService
     *
     * @var QuoteInterface
     */
    private $quoteService;

    /**
     * Create the event listener.
     */
    public function __construct(QuoteInterface $quoteService) {
        $this->quoteService = $quoteService;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $order = $event->order;
        $currency = $event->currency;
        $amount = $event->amount;

        if ($currency->code === "GBP") {
            //Send email

        } else if ($currency->code === "EUR") {
            //Apply discount
            $totalAmountUsd = $this->calculateTotalAmountUsd($currency, $amount);
            $totalAmountUsd -= $this->calculateDiscountAmount($currency, $amount);
            $order->amount_paid_usd = $totalAmountUsd;
            $order->save();
        }
    }
}

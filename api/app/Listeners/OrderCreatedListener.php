<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Http\Resources\OrderResource;
use App\Services\Contracts\QuoteInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
            $data = OrderResource::make($order)->toArray(request());
            $data['id'] = $order->id;
            Mail::to(config('app.order_created_notification_email'))->send(new \App\Mail\OrderCreated($data));
        } else if ($currency->code === "EUR") {
            //Calculate discount
            $amountToPayMoney = $this->quoteService->calculateAmountMoney($currency, $amount);
            $totalAmounMoney = $this->quoteService->calculateTotalAmountMoney($currency, $amountToPayMoney);
            $discountMoney = $this->quoteService->calculateDiscountAmountMoney($currency, $totalAmounMoney);
            $totalAmountWitDiscount = $totalAmounMoney->minus($discountMoney);
            //Apply discount
            $order->discount_percentage = $currency->getDiscountPercentage();
            $order->discount_amount = $discountMoney->getAmount()->__toString();
            $order->amount_paid_usd = $totalAmountWitDiscount->getAmount()->__toString();
            $order->save();
        }
    }
}

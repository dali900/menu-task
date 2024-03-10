<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Http\Requests\PurchaseRequest;
use App\Models\Currency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Create an order for the purchased currency
     *
     * @param  \App\Http\Requests\PurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function purchase(PurchaseRequest $request, $currencyCode)
    {
        $currency = Currency::where('code', $currencyCode)->first();
        // Retrieve all input data from the validated request
        $validated = $request->validated();

        // Calculate the amount in USD based on the input currency and amount
        $quote = app('App\Http\Controllers\CurrencyController')->calculateQuote($validated['currency'], $validated['amount']);

        // Calculate surcharge and discount based on currency
        $surcharge = $quote['surcharge'];
        $discount = $quote['discount'];

        // Create a new order
        $order = Order::create([
            'currency' => $validated['currency'],
            'exchange_rate' => $quote['exchange_rate'],
            'surcharge_percentage' => $surcharge,
            'surcharge_amount' => $quote['amount'] * ($surcharge / 100),
            'amount_purchased' => $validated['amount'],
            'amount_paid_usd' => $quote['amount_usd'],
            'discount_percentage' => $discount,
            'discount_amount' => $quote['amount'] * ($discount / 100),
            'created_at' => now(),
        ]);

        // Dispatch event based on currency
        if ($validated['currency'] === 'GBP') {
            // Dispatch email event for GBP orders
            event(new OrderCreatedEvent($order, $currency, $validated['amount']));
        } elseif ($validated['currency'] === 'EUR') {
            // Dispatch discount event for EUR orders
            // Implement logic for discount event if needed
        }

        // Return a success response
        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }
}

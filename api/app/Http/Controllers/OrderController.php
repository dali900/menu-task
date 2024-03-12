<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\OrderResource;
use App\Models\Currency;
use App\Models\Order;
use App\Services\Contracts\QuoteInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * QuoteService
     *
     * @var QuoteInterface
     */
    private $quoteService;

    public function __construct(QuoteInterface $quoteService) {
        $this->quoteService = $quoteService;
    }
    
    /**
     * Create an order for the purchased currency
     *
     * @param  \App\Http\Requests\PurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function purchase(PurchaseRequest $request, $currencyCode)
    {
        //Prepare data
        $amount = $request->amount;
        $currency = Currency::where('code', $currencyCode)->first();
        $validated = $request->validated();
        
        //Create model data
        $orderData = $this->quoteService->createOrderData($currency, $amount);
        $order = Order::create($orderData);

        event(new OrderCreatedEvent($order, $currency, $validated['amount']));

        // Return a success response
        return $this->responseSuccess([
            'order' => OrderResource::make($order)
        ]);
    }
}

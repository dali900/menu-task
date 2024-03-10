<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateQuoteRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use App\Services\Contracts\QuoteInterface;
use App\Services\QuoteService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
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
     * Display a listing of the resource.
     */
    public function getAllCurrencies()
    {
        $currencies = Currency::all();

        CurrencyResource::collection($currencies);
        return response()->json($currencies);
    }

    /**
     * Calculate the quote based on the selected currency and amount.
     *
     * @param string $currency
     * @param float $amount
     * @return array
     */
    public function calculateQuote(CalculateQuoteRequest $request, $currencyCode, $amount)
    {
        $currency = Currency::where('code', $currencyCode)->first();
        return $this->quoteService->calculateTotalAmountUsd($currency, $amount);
        //RESOURCE
    }
}

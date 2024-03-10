<?php
namespace App\Services\Contracts;

use App\Models\Currency;

interface QuoteInterface {

    /**
     * Calculate the quote based on the selected currency and amount.
     *
     * @param Currency $currency
     * @param float $amount
     * @return array
     */
	function calculateTotalAmountUsd(Currency $currency, float $amount): float;

    /**
     * Get discount amount
     *
     * @param Currency $currency
     * @param float $amount
     * @return float
     */
    function calculateDiscountAmount(Currency $currency, float $amount): float;

    /**
     * Create model data
     *
     * @param Currency $currency
     * @param float $amount
     * @return array
     */
    function createOrderData(Currency $currency, float $amount): array;
}
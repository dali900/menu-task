<?php
namespace App\Services\Contracts;

use App\Models\Currency;
use Brick\Money\Money;

interface QuoteInterface {
    /**
     * Get the calculatins for the amount to pay and total amount (amount + surcharge) 
     *
     * @param Currency $currency
     * @param int $amount
     * @return array
     */
    function getCalculations(Currency $currency, int $amount): array;

    /**
     * Calculate exchange amount
     *
     * @param Currency $currency
     * @param int $amount
     * @return Money
     */
    function calculateAmountMoney(Currency $currency, int $amount): Money;

    /**
     * Calculate total with surcharge amount
     *
     * @param Currency $currency
     * @param Money $amountMoney
     * @return Money
     */
    function calculateTotalAmountMoney(Currency $currency, Money $amountMoney): Money;

    /**
     * Get discount amount
     *
     * @param Currency $currency
     * @param Money $amountMoney
     * @return Money
     */
    function calculateDiscountAmountMoney(Currency $currency, Money $amountMoney): Money;

    /**
     * Get surcharge amount
     *
     * @param integer $surcharge_percentage
     * @param Money $amountMoney
     * @return Money
     */
    function calculateSurchargeAmountMoney(int $surcharge_percentage, Money $amountMoney): Money;

    /**
     * Create model data
     *
     * @param Currency $currency
     * @param int $amount
     * @return array
     */
    function createOrderData(Currency $currency, int $amount): array;
}
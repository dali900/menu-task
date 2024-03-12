<?php

namespace App\Services;

use App\Models\Currency;
use App\Services\Contracts\QuoteInterface;
use Brick\Money\Money;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CustomContext;
use Brick\Money\CurrencyConverter;
use Brick\Money\ExchangeRateProvider\ConfigurableProvider;
use Brick\Money\ExchangeRateProvider\BaseCurrencyProvider;

class QuoteService implements QuoteInterface
{
    /**
     * Get the calculatins for the amount to pay and total amount (amount + surcharge) 
     *
     * @param Currency $currency
     * @param int $amount
     * @return array
     */
    public function getCalculations(Currency $currency, int $amount): array
    {
        $amountToPayMoney = $this->calculateAmountMoney($currency, $amount);
        return [
            'amount' => $amountToPayMoney->__toString(),
            'surcharge_amount' => $this->calculateSurchargeAmountMoney($currency->surcharge_percentage, $amountToPayMoney)->__toString(),
            'total_amount' => $this->calculateTotalAmountMoney($currency, $amountToPayMoney)->__toString(),
        ];
    }

    /**
     * Calculate exchange amount
     *
     * @param Currency $currency
     * @param string $amount
     * @return Money
     */
    public function calculateAmountMoney(Currency $currency, int $amount): Money
    {
        $money = Money::of($amount, config('app.base_currency'), new CustomContext(6), RoundingMode::HALF_UP);
        return $money->dividedBy($currency->exchange_rate, RoundingMode::HALF_UP);
    }

    /**
     * Calculate total with surcharge amount
     *
     * @param Currency $currency
     * @param Money $amountMoney
     * @return Money
     */
    public function calculateTotalAmountMoney(Currency $currency, Money $amountMoney): Money
    {
        $surchargeAmountMoney = $this->calculateSurchargeAmountMoney($currency->surcharge_percentage, $amountMoney);
        return $surchargeAmountMoney->plus($amountMoney);
    }

    /**
     * Get discount amount
     *
     * @param Currency $currency
     * @param float $amount
     * @return float
     */
    public function calculateDiscountAmountMoney(Currency $currency, Money $amountMoney): Money
    {
        $discountPercentage = $currency->getDiscountPercentage();
        return $amountMoney->multipliedBy(($discountPercentage / 100), RoundingMode::HALF_UP);
    }
    
    /**
     * Get surcharge amount
     *
     * @param integer $surcharge_percentage
     * @param Money $amountMoney
     * @return Money
     */
    public function calculateSurchargeAmountMoney(int $surcharge_percentage, Money $amountMoney): Money
    {
        return $amountMoney->multipliedBy(($surcharge_percentage / 100), RoundingMode::HALF_UP);
    }

    /**
     * Create model data
     *
     * @param Currency $currency
     * @param int $amount
     * @return array
     */
    public function createOrderData(Currency $currency, int $amount): array
    { 
        $amountToPayMoney = $this->calculateAmountMoney($currency, $amount);
        $surchargeAmount = $this->calculateSurchargeAmountMoney($currency->surcharge_percentage, $amountToPayMoney);
        $totalAmount = $this->calculateTotalAmountMoney($currency, $amountToPayMoney);
        return [
            'currency_code' => $currency->code,
            'exchange_rate' => $currency->exchange_rate,
            'surcharge_percentage' => $currency->surcharge_percentage,
            'surcharge_amount' => $surchargeAmount->getAmount()->__toString(),
            'amount_purchased' => $amount,
            'amount_paid_usd' => $totalAmount->getAmount()->__toString(),
            'created_at' => now(),  
        ];
    }
}

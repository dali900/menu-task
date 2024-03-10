<?php

namespace App\Services;

use App\Models\Currency;
use App\Services\Contracts\QuoteInterface;

class QuoteService extends QuoteInterface
{
    /**
     * Calculate the quote based on the selected currency and amount.
     *
     * @param Currency $currency
     * @param float $amount
     * @return float
     */
    public function calculateTotalAmountUsd(Currency $currency, float $amount): float
    {
        $amountUsd = $this->calculateAmountUsd($currency, $amount);
        $surchargeAmount = $this->calculateSurchargeAmount($currency, $amountUsd);
        return $amountUsd + $surchargeAmount;
    }

    /**
     * Get discount amount
     *
     * @param Currency $currency
     * @param float $amount
     * @return float
     */
    public function calculateDiscountAmount(Currency $currency): float
    {
        $discountPercentage = $currency->getDiscountPercentage();
        return $this->$this->totalAmountUsd * ($discountPercentage / 100);
    }
    
    /**
     * Apply discount to the qoute
     *
     * @param Currency $currency
     * @param float $amount
     * @return float
     */
    /* public function calculateTotalAmountUsdWithDiscount(Currency $currency, float $amount) : float {
        $totalAmountUsd = $this->calculateTotalAmountUsd($currency, $amount);
        return $totalAmountUsd - $this->calculateDiscountAmount($currency, $amount);
    } */

    /**
     * Create model data
     *
     * @param Currency $currency
     * @param float $amount
     * @return array
     */
    public function createOrderData(Currency $currency, float $amount): array
    {
        $amountUsd = $this->calculateAmountUsd($currency, $amount);     
        return [
            'currency_code' => $currency->code,
            'exchange_rate' => $currency->exchange_rate,
            'surcharge_percentage' => $currency->surcharge_percentage,
            'surcharge_amount' => $this->calculateSurchargeAmount($currency, $amountUsd),
            'amount_purchased' => $amount,
            'amount_paid_usd' => $this->calculateTotalAmountUsd($currency, $amount),
            'discount_percentage' => $currency->getDiscountPercentage(),
            'discount_amount' => $this->calculateDiscountAmount($currency, $amount),
        ];
    }

    private function calculateAmountUsd(Currency $currency, float $amount): float
    {
        return $amount / $currency->exchange_rate;
    }
    
    private function calculateSurchargeAmount(Currency $currency, float $amountUsd): float
    {
        return $amountUsd * ($currency->surcharge_percentage / 100);
    }
}

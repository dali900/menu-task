<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'exchange_rate',
        'surcharge_percentage',
        'discount_percentage',
    ];

    public function getDiscountPercentage(): float
    {
        $discounts = config('discounts');
        return $discounts[$this->code] ?? 0;
    }

    /* public function calculateDiscountAmount($amount): float
    {
        $totalAmountUsd = $this->calculateTotalAmountUsd($currency, $amount);
        
        $discountPercentage = $currency->getDiscountPercentage();
        return $totalAmountUsd * ($discountPercentage / 100);
    }

    public function calculateAmountUsd(float $amount): float
    {
        return $amount / $this->exchange_rate;
    }
    
    public function calculateSurchargeAmount(float $amount): float
    {
        return $this->calculateAmountUsd($amount) * ($this->surcharge_percentage / 100);
    } */
}

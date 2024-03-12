<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Brick\Money\Money;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CustomContext;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalAmountUsd = Money::of($this->amount_paid_usd, config('app.base_currency'), new CustomContext(2), Currency::DEFAULT_ROUNDING);
        $discountAmount = null;
        if ($this->discount_amount) {
            $discountAmount = Money::of($this->discount_amount, config('app.base_currency'), new CustomContext(2), Currency::DEFAULT_ROUNDING);
            $totalAmountUsd->plus($discountAmount);
        }

        return [
            'currency_code' => $this->currency_code,
            'amount_purchased' => Money::of($this->amount_purchased, $this->currency_code, new CustomContext(2), Currency::DEFAULT_ROUNDING)->__toString(),
            'exchange_rate' => $this->exchange_rate,
            'surcharge_percentage' => $this->surcharge_percentage,
            'surcharge_amount' => Money::of($this->surcharge_amount, config('app.base_currency'), new CustomContext(2), Currency::DEFAULT_ROUNDING)->__toString(),
            'total_amount_usd' => $totalAmountUsd->__toString(),
            'discount_percentage' => $this->discount_percentage ?? 0,
            'discount_amount' => $discountAmount ? $discountAmount->__toString() : 0,
            'amount_paid_usd' => Money::of($this->amount_paid_usd, config('app.base_currency'), new CustomContext(2), Currency::DEFAULT_ROUNDING)->__toString(),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Brick\Math\RoundingMode;

class Currency extends Model
{
    use HasFactory;

    const DEFAULT_ROUNDING = RoundingMode::HALF_UP;

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
}

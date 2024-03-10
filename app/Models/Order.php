<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_code',
        'exchange_rate',
        'surcharge_percentage',
        'surcharge_amount',
        'amount_purchased',
        'amount_paid_usd',
        'discount_percentage',
        'discount_amount',
        'created_at'
    ];
}

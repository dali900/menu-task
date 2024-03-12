<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 3);
            $table->decimal('exchange_rate', 12, 6);
            $table->decimal('surcharge_percentage', 5, 2);
            $table->decimal('surcharge_amount', 12, 6);
            $table->decimal('amount_purchased', 12, 6);
            $table->decimal('amount_paid_usd', 12, 6);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('discount_amount', 12, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

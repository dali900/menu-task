<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currancy rates';

    /**
     * Execute the console command.
     * API service:
     * https://app.abstractapi.com/api/exchange-rates/tester
     */
    public function handle()
    {
        $currency = Currency::get();
        if (count($currency) > 0) {
            $currencyCodes = $currency->implode('code', ',');
            $apiKey = config('app.abstract_api_key');
            $base = config('app.base_currency');
            $url = "https://exchange-rates.abstractapi.com/v1/live/";
            $response = Http::acceptJson()->get($url, [
                'api_key' => $apiKey,
                'base' => $base,
                'target' => $currencyCodes,
            ]);
    
            if ($response->successful()) {
                $rates = $response->json()['exchange_rates'];
                foreach ($rates as $code => $rate) {
                    $this->line("CODE: ".$code);
                    $this->line("RATE: ".$rate);
                    Currency::where('code', $code)->update(['exchange_rate' => $rate]);
                }
                $this->info("Done!");
            } else {
                $this->error($response->status());
                $this->line($response->body());
            }
        } else {
            $this->warn("No currencies in DB. Please provide some currency.");
        } 
    }
}

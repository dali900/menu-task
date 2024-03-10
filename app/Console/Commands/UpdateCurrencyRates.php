<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-currency-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currancy rates from ';

    /**
     * Execute the console command.
     * https://app.abstractapi.com/api/exchange-rates/tester
     */
    public function handle()
    {
        
              // Initialize cURL.
              $ch = curl_init();

              // Set the URL that you want to GET by using the CURLOPT_URL option.
              curl_setopt($ch, CURLOPT_URL, 'https://exchange-rates.abstractapi.com/v1/live/?api_key=c2a77cf9f14848fdb62ba9be08995308&base=USD&target=EUR,JPY');

              // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

              // Execute the request.
              $data = curl_exec($ch);

              // Close the cURL handle.
              curl_close($ch);

              // Print the data out onto the page.
              echo $data;
              
    }
}

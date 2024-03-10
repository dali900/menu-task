<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->truncate();
		
		Currency::insert([
			[
				'name' => 'Japanese Yen',
				'code' => 'JPY',
				'exchange_rate' => 107.17,
				'surcharge_percentage' => 7.5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'British Pound',
				'code' => 'GBP',
				'exchange_rate' => 0.711178,
				'surcharge_percentage' => 5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Euro',
				'code' => 'EUR',
				'exchange_rate' => 0.884872,
				'surcharge_percentage' => 5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		]);
    }
}

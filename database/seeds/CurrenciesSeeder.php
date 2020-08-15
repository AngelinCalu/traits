<?php

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('currencies')->delete();

        Currency::create([
            'code' => 'EUR',
            'sub_unit' => 'cent:cents',
            'symbol' => '€',
            'decimals' => 2,
        ]);

        Currency::create([
            'code' => 'USD',
            'sub_unit' => 'cent:cents',
            'symbol' => '$',
            'decimals' => 2,
        ]);

        Currency::create([
            'code' => 'RON',
            'sub_unit' => 'ban:bani',
            'symbol' => 'leu:lei',
            'decimals' => 2,
        ]);
    }
}

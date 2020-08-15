<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Currency;
use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'code' => $faker->currencyCode(),
        'sub_unit' => 'cent:cents',
        'symbol' => '€',
        'decimals' => $faker->numberBetween(0,2)
    ];
});

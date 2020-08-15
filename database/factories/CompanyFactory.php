<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'business_id' => $faker->randomNumber(8),
        'vat_number' => $faker->randomNumber(8),
        'logo' => null,
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'parent_id' => null
    ];
});

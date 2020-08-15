<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {

    $personalExpense = $faker->boolean();

    return [
        'name' => $faker->sentence(4),
        'amount' => $faker->randomFloat(2,1,500),
        'currency_id' => function() {
            return factory(App\Models\Currency::class)->create()->id;
        },
        'user_id' => function($personalExpense) {
            return ($personalExpense) ? factory(App\Models\User::class)->create()->id : null;
        },
        'company_id' => function($personalExpense) {
            return ($personalExpense) ? null : factory(App\Models\Company::class)->create()->id;
        },
        'due_date' => $faker->date('Y-m-d','now'),
        'paid_on' => $faker->date('Y-m-d','now')
    ];
});

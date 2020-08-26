<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('expenses', 'ExpensesController@index');
Route::post('expenses', 'ExpensesController@store');


Route::auth();

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LocalizeController@sync');
Route::delete('/', 'LocalizeController@clear');

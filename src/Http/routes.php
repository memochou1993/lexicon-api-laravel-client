<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LocalizeController@export');
Route::delete('/', 'LocalizeController@clear');

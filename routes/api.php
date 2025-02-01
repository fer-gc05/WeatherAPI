<?php

use App\Http\Controllers\WeatherController;
use App\Http\Middleware\CustomRateLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/weather/{city}', [WeatherController::class, 'getWeather'])->middleware(CustomRateLimit::class);

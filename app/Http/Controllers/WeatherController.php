<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherController extends Controller
{
    public function getWeather($city)
    {
        $cacheKey = 'weather-' . $city;
        

        $weather = Cache::get($cacheKey);
        if ($weather) {
            return response()->json([
                'success' => true,
                'weather' => $weather
            ], 200);
        }

        $apiKey = env('WEATHER_API_KEY');
        $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$city}?unitGroup=metric&key={$apiKey}";

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not get weather information.'
                ], $response->status());
            }

            $weather = $response->json();
            Cache::put($cacheKey, $weather, now()->addHours(12));

            return response()->json([
                'success' => true,
                'weather' => $weather
            ], 200);
        } catch (HttpException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing request:' . $e->getMessage()
            ], 500);
        }
    }
}

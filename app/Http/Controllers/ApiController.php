<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\ApiLog;

class ApiController extends Controller
{

    public function weather()
    {
        $cacheKey = 'weather_lagos';

        // 1. Check cache FIRST
        if (Cache::has($cacheKey)) {
            return response()->json([
                'source' => 'cache',
                'data' => Cache::get($cacheKey),
            ]);
        }

        // 2. Call API only if cache MISS
        $response = Http::withoutVerifying()->get(
            'https://api.openweathermap.org/data/2.5/weather',
            [
                'q' => 'Lagos',
                'appid' => env('WEATHER_API_KEY'),
                'units' => 'metric',
            ]
        );

        $data = $response->json();

        // 3. Store in cache for 1 hour
        Cache::put($cacheKey, $data, 3600);

        return response()->json([
            'source' => 'api',
            'data' => $data,
        ]);
    }
}
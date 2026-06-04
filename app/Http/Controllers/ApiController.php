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
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => 'Lagos',
            'appid' => env('WEATHER_API_KEY'),
            'units' => 'metric',
        ]);
        return response()->json([
            'status' => 'success',
            'data' => $response->json(),
        ]);
    }
}
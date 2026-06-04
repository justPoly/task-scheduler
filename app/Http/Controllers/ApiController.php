<?php

namespace App\Http\Controllers;

use App\Models\ApiLog;

class ApiController extends Controller
{
    public function weather()
    {
        return response()->json([
            'status' => 'API works'
        ]);
    }
}
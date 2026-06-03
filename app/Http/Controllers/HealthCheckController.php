<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class HealthCheckController extends Controller
{
    public function check(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now(),
        ]);
    }
}

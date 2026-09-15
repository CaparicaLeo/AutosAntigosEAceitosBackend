<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::select('SELECT 1');

            return response()->json([
                'status' => 'ok',
                'database' => true,
            ]);
        } catch (Throwable) {
            return response()->json([
                'status' => 'unavailable',
                'database' => false,
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}

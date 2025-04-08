<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function apiResponse($data = null, $message = null, $statusCode = 200, $file = 'message'): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message ? __("$file.$message") : __("{$file}.true"),
            'data' => $data,
        ], $statusCode);
    }
}

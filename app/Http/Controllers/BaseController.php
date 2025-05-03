<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

abstract class BaseController extends Controller
{
    public function apiResponse($data = null, $message = null, $statusCode = 200, $file = 'message', $messageParams = []): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message ? __("$file.$message", $messageParams) : __("{$file}.true"),
            'data' => $data,
        ], $statusCode);
    }

    public function callAction($method, $parameters)
    {
        return DB::transaction(function () use ($method, $parameters) {
            return parent::callAction($method, $parameters);
        });
    }
}

<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function error(string $message = 'Error', $errors = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}

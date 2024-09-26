<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function responseApi($data, $message, $status): JsonResponse
    {
        $array = [
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($array, $status);
    }
}

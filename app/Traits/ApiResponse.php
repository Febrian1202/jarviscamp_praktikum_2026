<?php

namespace App\Traits;

/**
 * Format untuk response API
 */
trait ApiResponse
{
    /**
     * Format untuk response Sukses
     */
    protected function successResponse(
        $data = null,
        string $message = "Success",
        int $code = 200,
    ) {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
                "data" => $data,
            ],
            $code,
        );
    }

    /**
     * Format untuk response Error
     */
    protected function errorResponse(
        $data = null,
        string $message = "Error",
        int $code = 400,
    ) {
        return response()->json(
            [
                "success" => false,
                "message" => $message,
                "data" => $data,
            ],
            $code,
        );
    }
}

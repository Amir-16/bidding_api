<?php

namespace App\Traits;

trait ApiManage
{
    /**
     * Returns a JSON response for successful operations.
     *
     * @param  mixed  $data  The response data.
     * @param  string|null  $message  The optional success message.
     * @param  int  $statusCode  The HTTP status code, default is 200.
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, ?string $message = null, int $statusCode = 200)
    {
        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Returns a JSON response for errors.
     *
     * @param  string  $message  The error message.
     * @param  int  $errorCode  The application-specific error code, default is null.
     * @param  int  $statusCode  The HTTP status code, default is 500.
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(string $message, $errorCode = null, int $statusCode = 500)
    {
        $response = [
            'status' => 0,
            'message' => $message,
        ];

        if (! is_null($errorCode)) {
            $response['errorCode'] = $errorCode;
        }

        return response()->json($response, $statusCode);
    }
}

<?php

namespace App\Traits;
use Exception;

trait ApiResponse
{
    public function errorResponse(Exception $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json(['status' => 'error', 'message' => 'Məlumatları düzgün daxil edin', 'errors' => $e->validator->errors()], 422);
        }
        return response(['success' => false, 'message' => $e->getMessage()], 400);
    }

    public function successResponse(string $message = 'Məlumat əlavə edildi')
    {
        return response(['success' => true, 'message' => $message], 200);
    }

    public function dataResponse(string $message = 'Məlumat əlavə edildi', $data = null)
    {
        return response(['success' => true, 'message' => $message, 'data' => $data], 200);
    }

    public function simpleDataResponse($data = null)
    {
        return response(['success' => true, 'data' => $data], 200);
    }

    public function fetchResponse($count = 0, $data = null)
    {
        return response(['success' => true, 'count' => $count, 'data' => $data], 200);
    }

    public function logError(Exception $e)
    {
        $this->errorLogging(self::class . " " . __FUNCTION__ . " " . $e->getMessage() . $e->getLine() . $e->getFile());
    }
}
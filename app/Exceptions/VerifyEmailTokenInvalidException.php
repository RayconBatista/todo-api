<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class VerifyEmailTokenInvalidException extends Exception
{
    protected $message = 'Token not valid';
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->getMessage()
        ], 400);
    }
}

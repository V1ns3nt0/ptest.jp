<?php

namespace App\Exceptions;

use Exception;

/**
 * Class CustomApiValidationException
 * It is thrown out if the entered data is incorrect.
 * @package App\Exceptions
 */
class CustomApiValidationException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(["errors" => json_decode($this->getMessage())], 422);
    }
}

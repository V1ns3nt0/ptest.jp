<?php

namespace App\Exceptions;

use Exception;

/**
 * Class CustomApiLoginException
 * Throws if login attempt was failed.
 * @package App\Exceptions
 */
class CustomApiLoginException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(["message" => $this->getMessage()], 400);
    }
}

<?php

namespace App\Exceptions;

use Exception;

/**
 * Class CustomApiUpdateException
 * Thrown if an error occurred when updating the object.
 * @package App\Exceptions
 */
class CustomApiUpdateException extends Exception
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

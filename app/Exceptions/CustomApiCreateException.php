<?php

namespace App\Exceptions;

use Exception;

/**
 * Class CustomApiCreateException
 * Thrown if an error occurred when creating the object.
 * @package App\Exceptions
 */
class CustomApiCreateException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(["message" => $this->getMessage()], 404);
    }
}

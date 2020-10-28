<?php

namespace App\Exceptions;

use Exception;

class CustomApiValidationException extends Exception
{
    public function render($request)
    {
        return response()->json(["errors" => json_decode($this->getMessage())], 422);
    }
}

<?php

namespace App\Exceptions;

use Exception;

class CustomApiUpdateException extends Exception
{
    public function render($request)
    {
        return response()->json(["message" => $this->getMessage()], 400);
    }
}

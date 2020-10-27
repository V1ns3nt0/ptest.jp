<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data, $code, $message = null)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public function throwExceptionResponse($message, $code)
    {
        throw new HttpResponseException(
            new JsonResponse(['errors' => $message], $code)
        );
    }
}

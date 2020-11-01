<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * The method forms a request.
     *
     * @param $data
     * @param $code
     * @param null $message
     * @return JsonResponse
     */
    public function sendResponse($data, $code, $message = null)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}

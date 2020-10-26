<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\RegisterUserResource;
use App\Http\Resources\LoginUserResource;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::createNewUser($request);

        //add checking if user is created -> exception
        if (!$user) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. User is not created"], 404)
            );
        }

        return response()->json([
            'data' => new RegisterUserResource($user),
            'message' => "Register is success",
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $response = User::authentificate($request);

        //check if attempt is success or not
        if ($response === false) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Invalid userdata"], 422)
            );
        }

        return response()->json([
            'data' => $response,
            'message' => "Login is success",
        ], 200);
    }
}

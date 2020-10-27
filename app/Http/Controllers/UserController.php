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
use App\Http\Controllers\BaseController;


class UserController extends BaseController
{
    /**
     * @param RegisterUserRequest $request
     * @return mixed
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::createNewUser($request);
        } catch (Exception $exception) {
            $this->throwExceptionResponse("Something goes wrong. User is not created", 404);
        }

        return $this->sendResponse(
            new RegisterUserResource($user), 201, "Register is success"
        );
    }

    /**
     * @param LoginUserRequest $request
     * @return mixed
     */
    public function login(LoginUserRequest $request)
    {
        try {
            $response = User::authentificate($request);
        } catch (Exception $exception) {
            $this->throwExceptionResponse("Invalid userdata", 400);
        }

        return $this->sendResponse(
            $response, 200, "Login is success"
        );
    }
}

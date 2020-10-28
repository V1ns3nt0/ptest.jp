<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\CustomApiValidationException;

class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new CustomApiValidationException($validator->getMessageBag());
    }
}

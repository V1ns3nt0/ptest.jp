<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseApiRequest;

class UpdateTaskRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required'],
            'priority' => ['required', 'in:1,2,3,4,5'],
            'is_active' => ['boolean'],
        ];
    }
}

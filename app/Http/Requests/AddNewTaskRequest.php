<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class AddNewTaskRequest extends BaseApiRequest
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
            'description' => ['exclude_if:type_id,2'],
            'path' => ['exclude_if:type_id,1', 'file', 'mimes:jpeg,jpg,png'],
            'priority' => ["required", "in:1,2,3,4,5"],
            'deadline' => ['date'],
            'type_id' => ['required', 'integer', 'exists:task_types,id'],
        ];
    }
}

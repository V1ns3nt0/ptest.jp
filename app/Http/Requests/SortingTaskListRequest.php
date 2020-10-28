<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortingTaskListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order' => ['required', 'in:desc,asc'],
            'order_params' => ['required', 'in:created_at,updated_at,name'],
        ];
    }
}

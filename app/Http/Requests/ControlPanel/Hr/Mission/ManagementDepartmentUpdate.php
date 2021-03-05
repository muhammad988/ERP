<?php

namespace App\Http\Requests\ControlPanel\Hr\Mission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ManagementDepartmentUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize(): bool
//    {
//        return false;
//    }
//
    protected function failedValidation (Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules (): array
    {
        return [
            'mission_id'    => 'required',
            'department_id' => 'required',
            'start_date'    => 'required|date',
            'parent_id'     => 'required',
        ];
    }
}

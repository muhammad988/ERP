<?php

namespace App\Http\Requests\ControlPanel\Hr\Mission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ManagementSectorStore extends FormRequest
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
            'department_id' => 'required',
            'sector_id'    => 'required',
        ];
    }
}

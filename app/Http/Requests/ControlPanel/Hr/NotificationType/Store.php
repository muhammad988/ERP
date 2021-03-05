<?php

namespace App\Http\Requests\ControlPanel\Hr\NotificationType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Store extends FormRequest
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
        throw new HttpResponseException(response ()->json ($validator->errors (), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules (): array
    {
        return [
            'name_en'     => 'required|unique:notification_types',
            'name_ar'     => 'required|unique:notification_types',
            'module_name' => 'required|unique:notification_types',

        ];
    }
}

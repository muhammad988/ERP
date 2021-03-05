<?php

namespace App\Http\Requests\ControlPanel\Hr\NotificationType;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    /**
     * @param Validator $validator
     */
    protected function failedValidation (Validator $validator)
    {
        throw new HttpResponseException(response ()->json ($validator->errors (), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules (Request $request): array
    {
        return [
            'name_en'     => 'required|unique:notification_types,name_en,' . $request->id . ',id',
            'name_ar'     => 'required|unique:notification_types,name_ar,' . $request->id . ',id',
            'module_name' => 'required|unique:notification_types,module_name,' . $request->id . ',id',
        ];
    }
}

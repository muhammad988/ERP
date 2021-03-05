<?php

namespace App\Http\Requests\Authority;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class Update extends FormRequest
{

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function rules():array
    {
        return [
            'user_id' => 'required',
            'role_id' => 'required',
        ];
    }
}

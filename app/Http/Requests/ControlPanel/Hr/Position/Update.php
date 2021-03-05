<?php

namespace App\Http\Requests\ControlPanel\Hr\Position;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

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
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request):array
    {
        return [

            'name_en' => 'required|unique:positions,name_en,'.$request->id.',id',
            'name_ar' => 'required|unique:positions,name_ar,'.$request->id.',id',
        ];
    }
}

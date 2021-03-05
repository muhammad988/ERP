<?php

namespace App\Http\Requests\Hr\User;

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
    public function authorize(): bool
    {
        return true;
    }


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

            'financial_code' => 'required|unique:users,financial_code,'.$request->id.',id',
            'first_name_ar' => 'required',
            'first_name_en' => 'required',
            'last_name_en' => 'required',
            'last_name_ar' => 'required',
            'position_id' => 'required',
            'department_id' => 'required',
            'parent_id' => 'required',
            'contract_type_id' => 'required',
            'user_group_id' => 'required',
            'number_of_hours' => 'required',
            'basic_salary' => 'required',
            'gross_salary' => 'required',
            'taxes' => 'required',
            'insurance' => 'required',
        ];
    }
}

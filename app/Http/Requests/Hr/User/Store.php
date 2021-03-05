<?php

namespace App\Http\Requests\Hr\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class Store extends FormRequest
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
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'financial_code' => 'required|unique:users',
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
            'email' => 'required|unique:users',
            'password' => 'required',
        ];
    }


}

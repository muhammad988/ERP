<?php

namespace App\Http\Requests\ControlPanel\Project\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Store
 * @package App\Http\Requests\ControlPanel\Project\Donor
 */
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
    /**
     * @param Validator $validator
     */
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
            'name_en' => 'required|unique:suppliers',
            'name_ar' => 'required|unique:suppliers',
            'email' => 'required|unique:suppliers',
            'phone_number' => 'required|unique:suppliers',
            'place' => 'required',
            'account.*.bank_name' => 'required',
            'account.*.account_name' => 'required',
            'account.*.iban' => 'required',
        ];
    }
}

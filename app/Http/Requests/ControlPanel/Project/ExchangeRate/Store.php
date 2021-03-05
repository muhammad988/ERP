<?php

namespace App\Http\Requests\ControlPanel\Project\ExchangeRate;

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
            'mission_id' => 'required',
            'currency_id' => 'required',
            'due_date' => 'required',
            'exchange_rate' => 'required',
        ];
    }
}

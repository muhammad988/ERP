<?php

namespace App\Http\Requests\ControlPanel\Project\ExchangeRate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

/**
 * Class Update
 * @package App\Http\Requests\ControlPanel\Project\Donor
 */
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
            'mission_id' => 'required',
            'currency_id' => 'required',
            'due_date' => 'required',
            'exchange_rate' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Store,php
 * @package App\Http\Requests\Project\Proposal
 */
class Store extends FormRequest
{
    
    
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'service.service_type_id' => 'required',
//            'service.currency_id' => 'required',
//            'service.user_exchange_rate' => 'required',
            'service.service_model_id' => 'required',
//            'service_item.*.*' => 'required_if:service.payment_method_id,3296',
//            'service_item.*.*' => 'required_if:service.payment_method_id,3296',
//            'service_item.*.item_id' => 'required',
//            'service_item.*.quantity' => 'required',
//            'service_item.*.unit_cost' => 'required',
//            'service_item.*.total' => 'required',
//            'service_item.*.unit_id' => 'required',
//            'service_item_direct.*.*' => 'required_if:service.payment_method_id,3297',

        ];
    }
    
    
}

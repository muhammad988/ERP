<?php

namespace App\Http\Requests\Project\Proposal;

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
            'budget' => 'required|array',
            'budget.*' => 'required|string',
            'beneficiary' => 'required|array',
            'beneficiary.men.*' => 'required',
            'beneficiary.women.*' => 'required',
            'beneficiary.boys.*' => 'required',
            'beneficiary.girls.*' => 'required',
            'proposal' => 'required|array',
            'proposal.*' => 'required|string',
            'project' => 'required|array',
            'project.name_en' => 'required|string',
            'project.sector_id' => 'required|integer',
            'project.organisation_unit_id' => 'required|integer',
            'project.start_date' => 'required|date',
            'project.end_date' => 'required|date',

        ];
    }
    
    
}

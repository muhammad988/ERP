<?php

namespace App\Http\Requests\Project\Project;

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
            'project' => 'required|array',
            'project.context' => 'required|string',
            'project.link_to_cluster_objectives' => 'required|string',
            'project.implementation_plan' => 'required|string',
            'project.overall_objective' => 'required|string',
            'project.monitoring_evaluation' => 'required|string',
            'project.reporting' => 'required|string',
            'project.gender_marker' => 'required|string',
            'project.accountability' => 'required|string',
            'plan_file' => 'required|file',


        ];
    }


}

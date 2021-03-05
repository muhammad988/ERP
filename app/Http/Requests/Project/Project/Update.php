<?php

namespace App\Http\Requests\Project\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Update
 * @package App\Http\Requests\Project\Proposal
 */
class Update extends FormRequest
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
//            'project.overhead' => 'required',
//            'plan_file' => 'required|file',
            //            'beneficiary' => 'required|array',
            //            'beneficiary.*.organisation_unit' => 'required',
            //            'beneficiary.*.men' => 'required',
            //            'beneficiary.*.women' => 'required',
            //            'beneficiary.*.boys' => 'required',
            //            'beneficiary.*.girls' => 'required',
            //            'beneficiary.*.total' => 'required',
            //            'description' => 'required|array',
            //            'personnel.*.budget_line' => 'required',
            //            'personnel.*.category_option' => 'required',
            //            'personnel.*.unit' => 'required',
            //            'personnel.*.duration' => 'required',
            //            'personnel.*.quantity' => 'required',
            //            'personnel.*.unit_cost' => 'required',
            //            'personnel.*.chf' => 'required',
            //            'personnel.*.donor' => 'required',
            //            'personnel.*.in_kind' => 'required',
            //            'personnel.*.out_of_overhead' => 'required',
            //            'personnel.*.description' => 'required',
            //            'supplies' => 'required|array',
            //            'supplies.*.budget_line' => 'required',
            //            'supplies.*.category_option' => 'required',
            //            'supplies.*.unit' => 'required',
            //            'supplies.*.duration' => 'required',
            //            'supplies.*.quantity' => 'required',
            //            'supplies.*.unit_cost' => 'required',
            //            'supplies.*.chf' => 'required',
            //            'supplies.*.donor' => 'required',
            //            'supplies.*.in_kind' => 'required',
            //            'supplies.*.out_of_overhead' => 'required',
            //            'supplies.*.description' => 'required',
            //            'equipment' => 'required|array',
            //            'equipment.*.budget_line' => 'required',
            //            'equipment.*.category_option' => 'required',
            //            'equipment.*.unit' => 'required',
            //            'equipment.*.duration' => 'required',
            //            'equipment.*.quantity' => 'required',
            //            'equipment.*.unit_cost' => 'required',
            //            'equipment.*.chf' => 'required',
            //            'equipment.*.donor' => 'required',
            //            'equipment.*.in_kind' => 'required',
            //            'equipment.*.out_of_overhead' => 'required',
            //            'equipment.*.description' => 'required',
            //            'contractual' => 'required|array',
            //            'contractual.*.budget_line' => 'required',
            //            'contractual.*.category_option' => 'required',
            //            'contractual.*.unit' => 'required',
            //            'contractual.*.duration' => 'required',
            //            'contractual.*.quantity' => 'required',
            //            'contractual.*.unit_cost' => 'required',
            //            'contractual.*.chf' => 'required',
            //            'contractual.*.donor' => 'required',
            //            'contractual.*.in_kind' => 'required',
            //            'contractual.*.out_of_overhead' => 'required',
            //            'contractual.*.description' => 'required',
            //            'travel' => 'required|array',
            //            'travel.*.budget_line' => 'required',
            //            'travel.*.category_option' => 'required',
            //            'travel.*.unit' => 'required',
            //            'travel.*.duration' => 'required',
            //            'travel.*.quantity' => 'required',
            //            'travel.*.unit_cost' => 'required',
            //            'travel.*.chf' => 'required',
            //            'travel.*.donor' => 'required',
            //            'travel.*.in_kind' => 'required',
            //            'travel.*.out_of_overhead' => 'required',
            //            'travel.*.description' => 'required',
            //            'trans' => 'required|array',
            //            'trans.*.budget_line' => 'required',
            //            'trans.*.category_option' => 'required',
            //            'trans.*.unit' => 'required',
            //            'trans.*.duration' => 'required',
            //            'trans.*.quantity' => 'required',
            //            'trans.*.unit_cost' => 'required',
            //            'trans.*.chf' => 'required',
            //            'trans.*.donor' => 'required',
            //            'trans.*.in_kind' => 'required',
            //            'trans.*.out_of_overhead' => 'required',
            //            'trans.*.description' => 'required',
            //            'general' => 'required|array',
            //            'general.*.budget_line' => 'required',
            //            'general.*.category_option' => 'required',
            //            'general.*.unit' => 'required',
            //            'general.*.duration' => 'required',
            //            'general.*.quantity' => 'required',
            //            'general.*.unit_cost' => 'required',
            //            'general.*.chf' => 'required',
            //            'general.*.donor' => 'required',
            //            'general.*.in_kind' => 'required',
            //            'general.*.out_of_overhead' => 'required',
            //            'general.*.description' => 'required',
            //            'support_cost' => 'required|array',
            //            'support_cost.*.budget_line' => 'required',
            //            'support_cost.*.category_option' => 'required',
            //            'support_cost.*.unit' => 'required',
            //            'support_cost.*.duration' => 'required',
            //            'support_cost.*.quantity' => 'required',
            //            'support_cost.*.unit_cost' => 'required',
            //            'support_cost.*.chf' => 'required',
            //            'support_cost.*.donor' => 'required',
            //            'support_cost.*.in_kind' => 'required',
            //            'support_cost.*.out_of_overhead' => 'required',
            //            'support_cost.*.description' => 'required'

        ];
    }


}

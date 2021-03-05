<?php

namespace App\Http\Transformer\User;

use App\Model\Hr\User;

/**
 * Class UserEditTransformer
 * @package App\Http\Resources\User
 */
class UserEditTransformer
{
    /**
     * Transform the resource into an array.
     *
     * @param User $user
     * @return array
     */

    public function transform (User $user): array
    {
        return [
            'id'                             => $user->id,
            'employee_number'                => $user->employee_number,
            'phone_number'                   => $user->phone_number,
            'first_name_ar'                  => $user->first_name_ar,
            'first_name_en'                  => $user->first_name_en,
            'middle_name_ar'                 => $user->middle_name_ar,
            'middle_name_en'                 => $user->middle_name_en,
            'last_name_ar'                   => $user->last_name_ar,
            'last_name_en'                   => $user->last_name_en,
            'date_of_birth'                  => $user->date_of_birth,
            'gender_en'                      => $user->gender_en,
            'marital_status_id'              => $user->marital_status_id,
            'nationality_id'                 => $user->nationality_id,
            'identity_number'                => $user->identity_number,
            'visa_type_id'                   => $user->visa_type_id,
            'passport_date'                  => $user->passport_date,
            'passport_number'                => $user->passport_number,
            'visa_validity'                  => $user->visa_validity,
            'emergency_contact_name_en'      => $user->emergency_contact_name_en,
            'emergency_contact_name_ar'      => $user->emergency_contact_name_ar,
            'emergency_contact_relationship' => $user->emergency_contact_relationship,
            'emergency_contact_phone'        => $user->emergency_contact_phone,
            'position_category_id'           => $user->position->position_category_id,
            'position_id'                    => $user->position_id,
            'department_id'                  => $user->department_id,
            'parent_id'                      => $user->parent_id,
            'mission_id'                     => $user->department->mission_id,
            'contract_type_id'               => $user->contract_type_id,
            'project_id'                     => $user->project_id,
            'type_of_contract_id'            => $user->type_of_contract_id,
            'start_date'                     => $user->start_date,
            'end_date'                       => $user->end_date,
            'user_group_id'                  => $user->user_group_id,
            'number_of_hours'                => $user->number_of_hours,
            'note'                           => $user->note,
            'starting_salary'                => $user->starting_salary,
            'basic_salary'                   => $user->basic_salary,
            'gross_salary'                   => $user->gross_salary,
            'taxes'                          => $user->taxes,
            'insurance'                      => $user->insurance,
            'house_allowance'                => $user->house_allowance,
            'management_allowance'           => $user->management_allowance,
            'cell_phone_allowance'           => $user->cell_phone_allowance,
            'cost_of_living_allowance'       => $user->cost_of_living_allowance,
            'fuel_allowance'                 => $user->fuel_allowance,
            'appearance_allowance'           => $user->appearance_allowance,
            'transportation_allowance'       => $user->transportation_allowance,
            'on_behalf_user_id'              => $user->on_behalf_user_id,
            'disabled'                       => $user->disabled,
            'organisation_unit_id'           => $user->organisation_unit_id,

        ];
    }

}

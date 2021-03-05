<?php

namespace App\Http\Requests\ControlPanel\Project\ImplementingPartner;

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
            'name_en' => 'required|unique:implementing_partners,name_en,'.$request->id.',id',
            'name_ar' => 'required|unique:implementing_partners,name_ar,'.$request->id.',id',
            'email' => 'required|unique:implementing_partners,email,'.$request->id.',id',
            'phone_number' => 'required|unique:implementing_partners,phone_number,'.$request->id.',id',
            'account.*.bank_name' => 'required',
            'account.*.account_name' => 'required|unique:implementing_partner_accounts,account_name,'.$request->id.',implementing_partner_id',
            'account.*.iban' => 'required|unique:implementing_partner_accounts,iban,'.$request->id.',implementing_partner_id',
        ];
    }
}

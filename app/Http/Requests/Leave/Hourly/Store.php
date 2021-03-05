<?php

namespace App\Http\Requests\Leave\Hourly;

use Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
        return [
            'leave_type_id' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'file' => ''.($request->has('file') ? 'required|file|max:3000|mimes:pdf|mimetypes:application/pdf' : '').'',
        ];
    }


}

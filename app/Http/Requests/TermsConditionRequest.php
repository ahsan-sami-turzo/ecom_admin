<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermsConditionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'terms_and_conditions' => 'required',
            'condition_type_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'condition_type_id.required' => 'The condition type name field is required.'
        ];
    }
}

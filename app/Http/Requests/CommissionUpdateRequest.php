<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommissionUpdateRequest extends FormRequest
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
            'category_id' => 'required',
            'vendor_id' => 'required',
            'percent' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'vendor_id.required' => 'The vendor name field is required',
            'category_id.required' => 'The category name field is required',
            'percent.required' => 'The percentage field is required',
        ];
    }
}

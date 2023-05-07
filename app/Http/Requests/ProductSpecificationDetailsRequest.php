<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ProductSpecificationDetailsRequest extends FormRequest
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
            'specification_details_name' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'specification_details_name.required' => 'The specification details name field is required',
            'category_id.required' => 'The category name field is required.'
        ];
    }


}

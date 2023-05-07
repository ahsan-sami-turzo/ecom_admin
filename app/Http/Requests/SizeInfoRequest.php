<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeInfoRequest extends FormRequest
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
            'size' => 'required',
            'size_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'size_type_id.required' => 'The size type name field is required.'
        ];
    }
}

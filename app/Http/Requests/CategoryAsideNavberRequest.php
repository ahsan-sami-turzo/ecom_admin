<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAsideNavberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'category_id' => 'required',
            'effectiveDate' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'category_id.required' => 'The Parent category name field is required.',
        ];
    }
}

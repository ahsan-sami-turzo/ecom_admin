<?php

namespace App\Http\Requests;

use App\Models\FeatureName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeatureNameRequest extends FormRequest
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
            'name'  => 'nullable',
            'display_type'  => 'nullable',
            'display_products'  => 'required',
            //'display_serial'  => "unique:feature_name,display_serial,". $this->feature_name,
            'display_serial'  =>  [Rule::unique('feature_name')->ignore($this->feature_name)],

        ];
    }
}

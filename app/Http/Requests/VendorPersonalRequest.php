<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorPersonalRequest extends FormRequest
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
            'product_category' => 'required',
            'nid' => 'required',
            'phone' => 'required',
            'vendorImage'   => 'nullable|image|mimes:jpeg,png,jpg|max:1024|dimensions:min_width=40,min_height=40,max_width=240,max_height=240',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg|max:1024|dimensions:min_width=40,min_height=40,max_width=240,max_height=240',
            'brandImage'    => 'nullable|image|mimes:jpeg,png,jpg|max:2024|dimensions:min_width=40,min_height=40,max_width=1800,max_height=600',
            'cover_photo'   => 'nullable|image|mimes:jpeg,png,jpg|max:2024|dimensions:min_width=40,min_height=40,max_width=1800,max_height=600',
        ];
    }

    public function messages()
    {
        return [
            'vendorImage.dimensions' => "The vendor image field is size 240 X 240.",
            'vendorImage.max' => "Maximum file size to upload is !MB (1024 KB). If you are uploading a photo, try to reduce its resolution to make it under 1MB",
            'brandImage.dimensions' => "The vendor brand image field is size 1800 X 600.",
            'brandImage.max' => "Maximum file size to upload is !MB (1024 KB). If you are uploading a photo, try to reduce its resolution to make it under 1MB",
            'logo.dimensions' => "The vendor logo image field is size 240 X 240.",
            'logo.max' => "Maximum file size to upload is !MB (1024 KB). If you are uploading a photo, try to reduce its resolution to make it under 1MB",
            'cover_photo.dimensions' => "The vendor cover image field is size 1800 X 600.",
            'cover_photo.max' => "Maximum file size to upload is !MB (1024 KB). If you are uploading a photo, try to reduce its resolution to make it under 1MB",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBuisnessPageRequest extends FormRequest
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
            'store_title' => 'required|max:24|min:2',
            'store_description' => 'required|max:256',
            'store_email' => 'required|email',
            'store_phone' => 'required|min:10',
            'store_address' => 'required|max:64',
            'store_country' => 'required',
            'store_state' => 'required:max:24',
            'store_city' => 'required|max:24',
            'store_lat' => 'required|numeric|between:-99.99999999,99.99999999',
            'store_lon' => 'required|numeric|between:-199.99999999,199.99999999',
            'store_zip' => 'required|min:5',
            'store_picture' => 'mimes:jpeg,png|max:2000',
            'store_comment' => 'max:256'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePanelProductCategoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! isset(Auth::user()->id)) {
            return false;
        }
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
            'category_name' => 'required|max:24',
        ];
    }
    
    /**
     * Validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_name.required' => 'The Category Name field is required.',
            'category_name.max' => 'The Category Name may not be greater than 24 characters.'
        ];
    }
}

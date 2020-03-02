<?php
namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePanelAttributesProductRequest extends FormRequest
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
        if ($this->input('new_attribute_name') != NULL && $this->input('attribute_value') == NULL) {
            return [
                'new_attribute_name' => 'max:8'
            ];
        } elseif ($this->input('new_attribute_name') != NULL && $this->input('attribute_value') != NULL) {
            return [
                'attribute_value' => 'max:24',
                'new_attribute_name' => 'max:8'
            ];
        } elseif ($this->input('new_attribute_name') == NULL && $this->input('attribute_value') != NULL) {
            return [
                'attribute_value' => 'max:24'
            ];
        } else {
            return [ //
            ];
        }
    }

    /**
     * Validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'new_attribute_name.max' => 'The Attribute Name may not be greater than 8 characters.',
            'attribute_value.max' => 'The Attribute Name may not be greater than 24 characters.'
        ];
    }
}

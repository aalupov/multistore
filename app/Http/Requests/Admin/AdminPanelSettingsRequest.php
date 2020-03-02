<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminPanelSettingsRequest extends FormRequest
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
            'country_location' => 'required|max:2|regex:/^[A-Za-z\s-_]+$/',
            'api_key' => 'required',
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
            'country_location.required' => 'The Country Location field is required.',
            'country_location.max' => 'The Country Location may not be greater than 2 characters.',
            'country_location.regex' => 'The Country Location must not to context the numeric characters.',
            'api_key.required.required' => 'The Api Key field is required.',          
        ];
    }
}

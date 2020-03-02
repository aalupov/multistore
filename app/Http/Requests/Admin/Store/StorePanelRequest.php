<?php
namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePanelRequest extends FormRequest
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
        if (! empty($this->input('store_email'))) {

            $regex_twitter = '';
            $regex_instagram = '';
            $regex_facebook = '';
            if (! empty($this->input('store_twitter'))) {
                $regex_twitter = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            }
            if (! empty($this->input('store_instagram'))) {
                $regex_instagram = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            }
            if (! empty($this->input('store_facebook'))) {
                $regex_facebook = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            }

            return [
                'store_title' => 'required|max:24',
                'store_description' => 'max:256',
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
                'store_twitter' => $regex_twitter,
                'store_instagram' => $regex_instagram,
                'store_facebook' => $regex_facebook
            ];
        } else {
            return [];
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
            'store_twitter.regex' => 'Twitter url have to be a valid url',
            'store_instagram.regex' => 'Instagram url have to be a valid url',
            'store_facebook.regex' => 'Facebook url have to be a valid url'
        ];
    }
}

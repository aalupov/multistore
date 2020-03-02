<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminPanelUsersRequest extends FormRequest
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
        if (! empty($this->input('email')) && ! empty($this->input('password'))) {

            return [
                'email' => 'required|email',
                'password' => 'required|min:8|same:password',
                'password_confirmation' => 'required|min:8|same:password'
            ];
        } elseif (! empty($this->input('email')) && empty($this->input('password'))) {
            return [
                'email' => 'required|email'
            ];
        } else {
            return [];
        }
    }
}

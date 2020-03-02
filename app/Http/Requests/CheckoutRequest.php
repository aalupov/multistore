<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
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
 
        if (! isset(Auth::user()->id)) {
            $required = '';
            $email = '';
            $min10 = '';
            $min5 = '';
            if ($this->input('answer') != 1 && $this->input('virtual') != 1) {
                $required = 'required';
                $email = 'email';
                $min10 = 'min:10';
                $min5 = 'min:5';
            }

            return [
                'address.billing.first_name' => 'required',
                'address.shipping.first_name' => $required,
                'address.billing.last_name' => 'required',
                'address.shipping.last_name' => $required,
                'address.billing.email' => 'required|email',
                'address.shipping.email' => $required . '|' . $email,
                'address.billing.phone' => 'required|min:10',
                'address.shipping.phone' => $required . '|' . $min10,
                'address.billing.address' => 'required',
                'address.shipping.address' => $required,
                'address.billing.city' => 'required',
                'address.shipping.city' => $required,
                'address.billing.state' => 'required',
                'address.shipping.state' => $required,
                'address.billing.zip_code' => 'required|min:5',
                'address.shipping.zip_code' => $required . '|' . $min5,
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
            'address.billing.first_name.required' => 'The Billing First Name field is required.',
            'address.shipping.first_name.required' => 'The Shipping First Name field is required.',
            'address.billing.last_name.required' => 'The Billing Last Name field is required.',
            'address.shipping.last_name.required' => 'The Shipping Last Name field is required.',
            'address.billing.email.required' => 'The Billing Email field is required.',
            'address.billing.email.email' => 'The Billing Email must be a valid email address.',
            'address.shipping.email.required' => 'The Shipping Email field is required.',
            'address.shipping.email.email' => 'The Shipping Email must be a valid email address.',
            'address.billing.phone.required' => 'The Billing Phone field is required.',
            'address.billing.phone.min' => 'The Billing Phone must be at least 10 characters.',
            'address.shipping.phone.required' => 'The Shipping Phone field is required.',
            'address.shipping.phone.min' => 'The Shipping Phone must be at least 10 characters.',
            'address.billing.address.required' => 'The Billing Address field is required.',
            'address.shipping.address.required' => 'The Shipping Address field is required.',
            'address.billing.state.required' => 'The Billing State field is required.',
            'address.shipping.state.required' => 'The Shipping State field is required.',
            'address.billing.zip_code.required' => 'The Billing Zip Code field is required.',
            'address.billing.zip_code.min' => 'The Billing Zip Code must be at least 5 characters.',
            'address.shipping.zip_code.required' => 'The Shipping Zip Code field is required.',
            'address.shipping.zip_code.min' => 'The Shipping Zip Code must be at least 5 characters.',
        ];
    }
}

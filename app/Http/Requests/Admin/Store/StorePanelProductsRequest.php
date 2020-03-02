<?php
namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePanelProductsRequest extends FormRequest
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
        if (! empty($this->input('product_title'))) {
            $product_sale_price = '';
            $product_quantity = '';
            if (! empty($this->input('product_sale_price'))) {
                $product_sale_price = 'numeric';
            }
            if (! empty($this->input('product_quantity'))) {
                $product_quantity = 'numeric';
            }

            return [
                'product_title' => 'required|max:48',
                'product_description' => 'max:512',
                'product_regular_price' => 'required|numeric',
                'product_sale_price' => $product_sale_price,
                'product_quantity' => $product_quantity,
                'product_picture' => 'mimes:jpeg,png|max:2000',
                'product_categories' => 'required'
            ];
        } else {
            return [];
        }
    }
}

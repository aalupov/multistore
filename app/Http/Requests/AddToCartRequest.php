<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
        return [ //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->get('attribute_names')) {
            $this->merge([
                'attribute_values' => $this->convertRequestArray()
            ]);
        }
    }

    /**
     * Converting of request array.
     * Adding of the field "attributes_values".
     *
     * @return array
     */
    private function convertRequestArray()
    {
        $attrNames = $this->get('attribute_names');
        $attrValues = [];
        foreach ($attrNames as $item) {
            $attrValues[$item] = $this->get($item);
        }

        return $attrValues;
    }
}

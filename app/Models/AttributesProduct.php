<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributesProduct extends Model
{
    /**
     * Get the values of attributes for the product.
     */
    public function values_attributes()
    {
        return $this->hasMany(ValuesAttributesProduct::class, 'attribute_id');
    }
}

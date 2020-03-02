<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    
    /**
     * Get the reviews of the product.
     */
    public function reviews()
    {
        return $this->hasMany(ReviewsProduct::class, 'product_id');
    }
    
    /**
     * Get the attributes of the product.
     */
    public function attributes()
    {
        return $this->hasMany(AttributesProduct::class, 'product_id');
    }
    
    /**
     * Get the categories and the products relatioships.
     */
    public function store_categories_products()
    {
        return $this->hasMany(CategoryProductsRelationships::class, 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProducts extends Model
{
    use SoftDeletes;
    
    /**
     * Get the categories and the products relatioships.
     */
    public function store_categories_products()
    {
        return $this->hasMany(CategoryProductsRelationships::class, 'category_id');
    }
    
    /**
     * Get parents of the categories.
     */
    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}

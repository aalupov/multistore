<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stores extends Model
{
    use SoftDeletes;
    
    /**
     * Get the products of the store.
     */
    public function products()
    {
        return $this->hasMany(Products::class, 'store_id');
    }
    
    /**
     * Get the categories of the store.
     */
    public function categories()
    {
        return $this->hasMany(CategoryProducts::class, 'store_id');
    }
    
    /**
     * Get the categories and the products relatioships.
     */
    public function store_categories_products()
    {
        return $this->hasMany(CategoryProductsRelationships::class, 'store_id');
    }
    
    /**
     * Get the time shedule of the store.
     */
    public function time_shedule()
    {
        return $this->hasMany(StoresTimeShedule::class, 'store_id');
    }
    
    /**
     * Get the social links of the store.
     */
    public function social_links()
    {
        return $this->hasOne(StoresSocialLinks::class, 'store_id');
    }
    
    /**
     * Get the reviews for the products.
     */
    public function reviews()
    {
        return $this->hasMany(ReviewsProduct::class, 'store_id');
    }
    
    
}

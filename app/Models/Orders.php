<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{

    use SoftDeletes;
    
    /**
     * Converting of updated_at date.
     *
     * @param string $value
     * @return void
     */
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->isoFormat('MMM Do YYYY, h:mm a');
    }
    
    /**
     * Get the products of the order.
     */
    public function products()
    {
        return $this->hasMany(OrdersProducts::class, 'order_id');
    }

    /**
     * Get the addresses of the order.
     */
    public function addresses()
    {
        return $this->hasMany(OrdersAddresses::class, 'order_id');
    }
    
    /**
     * Get the comments of the order.
     */
    public function comments()
    {
        return $this->hasMany(OrdersComments::class, 'order_id');
    }
    
    /**
     * Get the comments of the order.
     */
    public function attributes_values()
    {
        return $this->hasMany(OrdersProductsAttributesValues::class, 'order_id');
    }
}

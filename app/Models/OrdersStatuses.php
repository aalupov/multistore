<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersStatuses extends Model
{
    public $timestamps = false;
    
    /**
     * Get order status name at uppercase.
     *
     * @param string $value
     * @return void
     */
    public function getOrderStatusAttribute($value)
    {
        return strtoupper($value);
    }
}

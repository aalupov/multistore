<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewsProduct extends Model
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
}

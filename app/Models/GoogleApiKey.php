<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleApiKey extends Model
{
    public $timestamps = false;

    /**
     * Get Country location at uppercase.
     *
     * @param string $value
     * @return void
     */
    public function getCountryLocationAttribute($value)
    {
        return strtoupper($value);
    }
}

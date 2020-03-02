<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoresSocialLinks extends Model
{

    /**
     * Get the twitter url.
     *
     * @param string $value
     * @return string
     */
    public function getTwitterAttribute($value)
    {
        return '<a href=' . $value . ' target="_blank"><img src="/img/twitter.png" width="25" height="25"></a>';
    }

    /**
     * Get the instagram url.
     *
     * @param string $value
     * @return string
     */
    public function getInstagramAttribute($value)
    {
        return '<a href=' . $value . ' target="_blank"><img src="/img/instagram.png" width="25" height="25"></a>';
    }

    /**
     * Get the facebook url.
     *
     * @param string $value
     * @return string
     */
    public function getFacebookAttribute($value)
    {
        return '<a href=' . $value . ' target="_blank"><img src="/img/facebook.png" width="25" height="25"></a>';
    }
}

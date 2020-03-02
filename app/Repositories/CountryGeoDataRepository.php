<?php
namespace App\Repositories;

use App\Models\CountryGeoData as Model;

/**
 * Class CountryGeoDataRepository
 *
 * @package App\Repositories
 */
class CountryGeoDataRepository extends CoreRepository
{

    /**
     *
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get the geo data by country
     *
     * @param string $countryCode
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getGeoDataByCountry($countryCode)
    {
        $result = $this->startConditions()
            ->select('latitude', 'longitude')
            ->where('country_code', '=', $countryCode)
            ->first();

        return $result;
    }
}
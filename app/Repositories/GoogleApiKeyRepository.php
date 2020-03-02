<?php
namespace App\Repositories;

use App\Models\GoogleApiKey as Model;

/**
 * Class GoogleApiKeyRepository
 *
 * @package App\Repositories
 */
class GoogleApiKeyRepository extends CoreRepository
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
     * Get Api key and the current country code of multistore
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getApiKeyAndCountryCode()
    {
        $result = $this->startConditions()->find(1);

        return $result;
    }

    /**
     * Update google api key
     *
     * $param array $data
     *
     * @return void
     */
    public function updateApiKeyAndCountryCode($data)
    {
        $this->startConditions()
            ->where('id', 1)
            ->update([
            'country_location' => $data['country_location'],
            'google_api_keys' => $data['api_key']
        ]);
    }

    /**
     * Insert google api key
     *
     * $param array $data
     *
     * @return void
     */
    public function insertApiKeyAndCountryCode($data)
    {
        $this->startConditions()->insert([
            'country_location' => $data['country_location'],
            'google_api_keys' => $data['api_key']
        ]);
    }
}
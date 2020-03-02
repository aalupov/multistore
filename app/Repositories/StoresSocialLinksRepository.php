<?php
namespace App\Repositories;

use App\Models\StoresSocialLinks as Model;

/**
 * Class StoresSocialLinksRepository
 *
 * @package App\Repositories
 */
class StoresSocialLinksRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'store_id',
        'twitter',
        'facebook',
        'instagram'
    ];

    /**
     *
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get Model to edit
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get the social links from the stores
     *
     * @param int $store_id
     *
     * @return App\Models\StoresSocialLinks
     */
    public function getSocialLinksByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_id', $store_id)
            ->first();

        return $result;
    }

    /**
     * Check exist store id
     *
     * @param int $store_id
     *
     * @return App\Models\StoresSocialLinks
     */
    public function checkStoreId($store_id)
    {
        $result = $this->startConditions()
            ->select('id')
            ->where('store_id', $store_id)
            ->first();

        return $result;
    }

    /**
     * add the store id
     *
     * @param int $store_id
     *
     * @return void
     */
    public function addStoreId($store_id)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Add twitter
     *
     * @param int $store_id
     * @param string $url
     *
     * @return void
     */
    public function addTwitter($store_id, $url)
    {
        $this->startConditions()
            ->where('store_id', $store_id)
            ->update([
            'twitter' => $url
        ]);
    }

    /**
     * Add instagram
     *
     * @param int $store_id
     * @param string $url
     *
     * @return void
     */
    public function addInstagram($store_id, $url)
    {
        $this->startConditions()
            ->where('store_id', $store_id)
            ->update([
            'instagram' => $url
        ]);
    }

    /**
     * Add facebook
     *
     * @param int $store_id
     * @param string $url
     *
     * @return void
     */
    public function addFacebook($store_id, $url)
    {
        $this->startConditions()
            ->where('store_id', $store_id)
            ->update([
            'facebook' => $url
        ]);
    }
}
<?php
namespace App\Repositories;

use App\Models\Stores as Model;

/**
 * Class StoresRepository
 *
 * @package App\Repositories
 */
class StoresRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'store_title',
        'store_description',
        'store_email',
        'store_country',
        'store_zip',
        'store_state',
        'store_city',
        'store_phone',
        'store_address',
        'store_picture',
        'store_lat',
        'store_lon',
        'store_is_activated'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'products.id',
        'products.store_id',
        'stores.store_title',
        'products.product_title',
        'products.product_sku',
        'products.product_regular_price',
        'products.product_sale_price',
        'products.product_picture',
        'products.product_description',
        'products.product_quantity',
        'products.product_type'
    ];

    /**
     * const array
     */
    private const COLUMNS_3 = [
        'id',
        'store_id',
        'product_id',
        'rating'
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
     * Get the list of active stores
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllActiveStores()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_is_activated', true)
            ->with([
            'time_shedule' => function ($query) {
                $query->orderBy('day_of_week');
            },
            'reviews' => function ($query) {
                $query->select(self::COLUMNS_3);
                $query->where('published', true);
            }
        ])
            ->get();

        return $result;
    }

    /**
     * Get the list of stores
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllStores()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the store email and store name by store id
     *
     * @param int $store_id
     *
     * @return App\Models\Stores
     */
    public function getStoreEmailAndStoreNameByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->select('store_email', 'store_title')
            ->where('id', $store_id)
            ->first();

        return $result;
    }

    /**
     * Get the list of stores with Kimit
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStoresWithLimit()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    /**
     * Seaching of the stores
     *
     * @param string $string
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function seachStores($string)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_title', 'LIKE', '%' . $string . '%')
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the store info by id
     *
     * @param int $id
     *
     * @return App\Models\Stores
     */
    public function getStoreInfoById($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->with([
            'products' => function ($query) {
                $query->join('stores', 'stores.id', '=', 'products.store_id');
                $query->select(self::COLUMNS_2);
                $query->where('products.product_quantity', '!=', 0);
                $query->orderBy('products.updated_at', 'desc');
            },
            'categories:id,store_id,parent_id,category_name',
            'store_categories_products:store_id,category_id,product_id',
            'time_shedule' => function ($query) {
                $query->orderBy('day_of_week');
            },
            'reviews' => function ($query) {
                $query->select(self::COLUMNS_3);
                $query->where('published', true);
            }
        ])
            ->get();

        return $result[0];
    }

    /**
     * Get the store info by id for contact form page
     *
     * @param int $id
     *
     * @return App\Models\Stores
     */
    public function getStoreInfoByIdForContactForm($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->with([
            'categories:id,store_id,parent_id,category_name',
            'time_shedule' => function ($query) {
                $query->orderBy('day_of_week');
            },
            'reviews' => function ($query) {
                $query->select(self::COLUMNS_3);
                $query->where('published', true);
            }
        ])
            ->get();

        return $result[0];
    }

    /**
     * Get the store info by id with social links and time shedules
     *
     * @param int $id
     *
     * @return App\Models\Stores
     */
    public function getStoreInfoByIdWithShedule($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->with([
            'time_shedule' => function ($query) {
                $query->orderBy('day_of_week');
            }
        ])
            ->get();

        return $result[0];
    }

    /**
     * add the store
     *
     * @param array $data
     *
     * @return void
     */
    public function addStore($data)
    {
        $this->startConditions()->insert([
            'store_title' => $data['store_title'],
            'store_description' => $data['store_description'],
            'store_email' => $data['store_email'],
            'store_phone' => $data['store_phone'],
            'store_address' => $data['store_address'],
            'store_country' => $data['store_country'],
            'store_state' => $data['store_state'],
            'store_city' => $data['store_city'],
            'store_zip' => $data['store_zip'],
            'store_lat' => $data['store_lat'],
            'store_lon' => $data['store_lon'],
            'store_is_activated' => $data['store_is_activated'],
            'store_picture' => $data['store_picture'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * update the store
     *
     * @param array $data
     *
     * @return void
     */
    public function updateStore($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'store_title' => $data['store_title'],
            'store_description' => $data['store_description'],
            'store_email' => $data['store_email'],
            'store_phone' => $data['store_phone'],
            'store_address' => $data['store_address'],
            'store_country' => $data['store_country'],
            'store_state' => $data['store_state'],
            'store_city' => $data['store_city'],
            'store_zip' => $data['store_zip'],
            'store_lat' => $data['store_lat'],
            'store_lon' => $data['store_lon'],
            'store_is_activated' => $data['store_is_activated'],
            'store_picture' => $data['store_picture']
        ]);
    }

    /**
     * update the store without the picture
     *
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function updateStoreWithoutPicture($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'store_title' => $data['store_title'],
            'store_description' => $data['store_description'],
            'store_email' => $data['store_email'],
            'store_phone' => $data['store_phone'],
            'store_address' => $data['store_address'],
            'store_country' => $data['store_country'],
            'store_state' => $data['store_state'],
            'store_city' => $data['store_city'],
            'store_zip' => $data['store_zip'],
            'store_lat' => $data['store_lat'],
            'store_lon' => $data['store_lon'],
            'store_is_activated' => $data['store_is_activated']
        ]);
    }

    /**
     * delete the store
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteStore($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
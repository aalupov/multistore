<?php
namespace App\Repositories;

use App\Models\AttributesProduct as Model;

/**
 * Class AttributesProductRepository
 *
 * @package App\Repositories
 */
class AttributesProductRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'attribute_name'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'attributes_products.id',
        'attributes_products.attribute_name',
        'products.product_title',
        'attributes_products.product_id'
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
     * Get the attributes by product id
     *
     * @param int $product_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAttributesByProductId($product_id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('product_id', $product_id)
            ->with([
            'values_attributes'
        ])
            ->get();

        return $result;
    }

    /**
     * Get the attributes by store id
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAttributesByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->join('products', 'products.id', '=', 'attributes_products.product_id')
            ->select(self::COLUMNS_2)
            ->where('attributes_products.store_id', $store_id)
            ->with([
            'values_attributes'
        ])
            ->orderBy('products.product_title')
            ->get();

        return $result;
    }

    /**
     * add the new attribute
     *
     * @param int $store_id
     * @param string $name
     * @param int $product_id
     *
     * @return void
     */
    public function addAttribute($store_id, $name, $product_id)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'attribute_name' => $name,
            'product_id' => $product_id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Delete the attribute
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteAttribute($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
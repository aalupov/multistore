<?php
namespace App\Repositories;

use App\Models\OrdersProductsAttributesValues as Model;

/**
 * Class OrdersProductsAttributesValuesRepository
 *
 * @package App\Repositories
 */
class OrdersProductsAttributesValuesRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id'
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
     * add the attributes values of the product to the order
     *
     * @param int $order_id
     * @param int $product_id
     * @param string $attribute_name
     * @param string $attribute_value
     *
     * @return void
     */
    public function addProductAttributeValueToOrder($order_id, $product_id, $attribute_name, $attribute_value)
    {
        $this->startConditions()->insert([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'attribute_name' => $attribute_name,
            'attribute_value' => $attribute_value,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
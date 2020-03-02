<?php
namespace App\Repositories;

use App\Models\OrdersProducts as Model;

/**
 * Class OrdersProductsRepository
 *
 * @package App\Repositories
 */
class OrdersProductsRepository extends CoreRepository
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
     * add the product to the order
     *
     * @param int $order_id
     * @param int $store_id
     * @param int $product_id
     * @param int @product_qty
     *
     * @return void
     */
    public function addProductToOrder($order_id, $store_id, $product_id, $product_qty)
    {
        $this->startConditions()->insert([
            'order_id' => $order_id,
            'store_id' => $store_id,
            'product_id' => $product_id,
            'product_order_quantity' => $product_qty,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
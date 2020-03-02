<?php
namespace App\Repositories;

use App\Models\Orders as Model;

/**
 * Class OrdersRepository
 *
 * @package App\Repositories
 */
class OrdersRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'orders.id',
        'orders.user_id',
        'orders.order_number',
        'orders.shipping_amount',
        'orders.payment_fee',
        'orders.total_amount',
        'orders.updated_at',
        'orders.ip_address',
        'orders_statuses.order_status'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'orders_products.product_id',
        'orders_products.order_id',
        'orders_products.store_id',
        'stores.store_title',
        'orders_products.product_order_quantity',
        'products.product_title',
        'products.product_sku',
        'products.product_regular_price',
        'products.product_sale_price',
        'products.product_picture',
        'products.product_type'
    ];

    /**
     * const array
     */
    private const COLUMNS_3 = [
        'orders_addresses.order_id',
        'orders_addresses.address_type',
        'orders_addresses.first_name',
        'orders_addresses.last_name',
        'orders_addresses.email',
        'orders_addresses.phone',
        'orders_addresses.address',
        'orders_addresses.city',
        'orders_addresses.country',
        'orders_addresses.state',
        'orders_addresses.zip_code'
    ];

    /**
     * const array
     */
    private const COLUMNS_4 = [
        'orders.id',
        'orders.order_number',
        'orders.total_amount',
        'orders_statuses.order_status',
        'orders.updated_at',
        'orders.ip_address',
        'users.name'
    ];

    /**
     * const array
     */
    private const COLUMNS_5 = [
        'orders_comments.id',
        'orders_comments.store_id',
        'orders_comments.order_id',
        'orders_comments.order_comment',
        'orders_comments.updated_at'
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
     * Get the orders by user id
     *
     * @param int $user_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersByUserId($user_id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('orders.user_id', $user_id)
            ->orderBy('orders.id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the orders with limits
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersWithLimit()
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    /**
     * Get the orders with limits
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersWithLimitByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->with([
            'products' => function ($query) use ($store_id) {
                $query->where('store_id', $store_id);
                $query->select('id', 'order_id', 'store_id');
            }
        ])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    /**
     * Get the orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrders()
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(self::COLUMNS_4)
            ->get();

        return $result;
    }

    /**
     * Get the orders for guests
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersForGuests()
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('orders.user_id', 0)
            ->get();

        return $result;
    }

    /**
     * Get the orders by store id
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(self::COLUMNS_4)
            ->with([
            'products' => function ($query) use ($store_id) {
                $query->where('store_id', $store_id);
                $query->select('id', 'order_id', 'store_id');
            }
        ])
            ->get();

        return $result;
    }

    /**
     * Get the orders for guests by store id
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersForGuestsByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('orders.user_id', 0)
            ->with([
            'products' => function ($query) use ($store_id) {
                $query->where('store_id', $store_id);
                $query->select('id', 'order_id', 'store_id');
            }
        ])
            ->get();

        return $result;
    }

    /**
     * Get the order id by order number
     *
     * @param string $order_number
     *
     * @return App\Models\Orders|NULL
     */
    public function getOrderIdByOrderNumber($order_number)
    {
        $result = $this->startConditions()
            ->select('id')
            ->where('order_number', $order_number)
            ->first();

        return $result;
    }

    /**
     * Get the user id and order number by order id
     *
     * @param int $order_id
     *
     * @return App\Models\Orders
     */
    public function getUserIdAndOrderNumberByOrderId($order_id)
    {
        $result = $this->startConditions()
            ->select('user_id', 'order_number')
            ->where('id', $order_id)
            ->first();

        return $result;
    }

    /**
     * Get the order by order id
     *
     * @param int $id
     *
     * @return App\Models\Orders
     */
    public function getOrderByOrderId($id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('orders.id', $id)
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'orders_products.product_id');
                $query->join('stores', 'stores.id', '=', 'orders_products.store_id');

                $query->select(self::COLUMNS_2);
            },
            'addresses' => function ($query) {
                $query->select(self::COLUMNS_3);
            },
            'comments' => function ($query) {
                $query->select(self::COLUMNS_5);
                $query->orderBy('orders_comments.id', 'desc');
            },
            'attributes_values:id,order_id,product_id,attribute_name,attribute_value'
        ])
            ->get();

        return $result[0];
    }

    /**
     * Get the order by order id and store_id
     *
     * @param int $id
     * @param int $store_id
     *
     * @return App\Models\Orders
     */
    public function getOrderByOrderIdAndStoreId($id, $store_id)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('orders.id', $id)
            ->with([
            'products' => function ($query) use ($store_id) {
                $query->join('products', 'products.id', '=', 'orders_products.product_id');
                $query->join('stores', 'stores.id', '=', 'orders_products.store_id');
                $query->where('orders_products.store_id', $store_id);
                $query->select(self::COLUMNS_2);
            },
            'addresses' => function ($query) {
                $query->select(self::COLUMNS_3);
            },
            'comments' => function ($query) use ($store_id) {
                $query->select(self::COLUMNS_5);
                $query->where('orders_comments.store_id', $store_id);
                $query->orderBy('orders_comments.id', 'desc');
            },
            'attributes_values:id,order_id,product_id,attribute_name,attribute_value'
        ])
            ->get();

        return $result[0];
    }

    /**
     * create the new order
     *
     * @param array $data
     *
     * @return int $result
     */
    public function createNewOrder($data)
    {
        $result = $this->startConditions()->insertGetId([
            'user_id' => $data['user_id'],
            'order_number' => $data['order_number'],
            'shipping_amount' => $data['shipping_amount'],
            'payment_fee' => $data['payment_fee'],
            'total_amount' => $data['total_amount'],
            'order_status_id' => $data['order_status_id'],
            'ip_address' => $data['ip_address'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return $result;
    }

    /**
     * update status of the order
     *
     * @para int $id
     * @param int $status_id
     *
     * @return void
     */
    public function updateStatusOrder($id, $status_id)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'order_status_id' => $status_id
        ]);
    }

    /**
     * seach an order by order number
     *
     * @param string $string
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function seachOrderByNumber($string)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('order_number', 'LIKE', '%' . $string . '%')
            ->get();

        return $result;
    }

    /**
     * seach an order by order number for the store
     *
     * @param int $store_id
     * @param string $string
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function seachOrderByNumberForStore($store_id, $string)
    {
        $result = $this->startConditions()
            ->join('orders_statuses', 'orders_statuses.id', '=', 'orders.order_status_id')
            ->select(self::COLUMNS)
            ->where('order_number', 'LIKE', '%' . $string . '%')
            ->with([
            'products' => function ($query) use ($store_id) {
                $query->where('store_id', $store_id);
                $query->select('id', 'order_id', 'store_id');
            }
        ])
            ->get();

        return $result;
    }

    /**
     * Get summed up total amount
     *
     * @return decimal
     */
    public function sumTotalAmount()
    {
        $result = $this->startConditions()->sum('total_amount');

        return $result;
    }

    /**
     * delete the new order
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteOrder($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
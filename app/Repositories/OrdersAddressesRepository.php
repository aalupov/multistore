<?php
namespace App\Repositories;

use App\Models\OrdersAddresses as Model;

/**
 * Class OrdersAddressesRepository
 *
 * @package App\Repositories
 */
class OrdersAddressesRepository extends CoreRepository
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
     * Get the user email and user name by order id
     *
     * @param int $order_id
     *
     * @return App\Models\OrdersAddresses
     */
    public function getUserEmailAndUserNameByOrderId($order_id)
    {
        $result = $this->startConditions()
            ->select('email', 'first_name', 'last_name')
            ->where('order_id', $order_id)
            ->where('address_type', 'billing')
            ->first();

        return $result;
    }

    /**
     * add the address to the order
     *
     * @param int $order_id
     * @param string $address_type
     * @param array $address
     *
     * @return void
     */
    public function addAddressToOrder($order_id, $address_type, $address)
    {
        $this->startConditions()->insert([
            'order_id' => $order_id,
            'address_type' => $address_type,
            'first_name' => $address['first_name'],
            'last_name' => $address['last_name'],
            'email' => $address['email'],
            'phone' => $address['phone'],
            'address' => $address['address'],
            'city' => $address['city'],
            'country' => $address['country'],
            'state' => $address['state'],
            'zip_code' => $address['zip_code'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
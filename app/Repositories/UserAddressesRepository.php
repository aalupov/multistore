<?php
namespace App\Repositories;

use App\Models\UserAddresses as Model;

/**
 * Class UserAddressesRepository
 *
 * @package App\Repositories
 */
class UserAddressesRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'state',
        'zip_code'
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
     * add the address to the user
     *
     * @param int $user_id
     * @param array $address
     *
     * @return void
     */
    public function addAddressToUser($user_id, $address)
    {
        $this->startConditions()->insert([
            'user_id' => $user_id,
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

    /**
     * update the address to the user
     *
     * @param int $id
     * @param array $address
     *
     * @return void
     */
    public function updateAddressToUser($id, $address)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'first_name' => $address['first_name'],
            'last_name' => $address['last_name'],
            'email' => $address['email'],
            'phone' => $address['phone'],
            'address' => $address['address'],
            'city' => $address['city'],
            'country' => $address['country'],
            'state' => $address['state'],
            'zip_code' => $address['zip_code']
        ]);
    }

    /**
     * Get the addresses by user id
     *
     * @param int $user_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAddressesByUserId($user_id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the address by id
     *
     * @param int $id
     *
     * @return App\Models\UserAddresses
     */
    public function getAddressById($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->find($id);

        return $result;
    }

    /**
     * delete the address
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteAddress($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
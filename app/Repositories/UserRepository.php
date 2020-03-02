<?php
namespace App\Repositories;

use App\User as Model;

/**
 * Class AttributesProductRepository
 *
 * @package App\Repositories
 */
class UserRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'name',
        'email',
        'is_general_admin',
        'is_store_admin',
        'store_id',
        'email_verified_at'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'is_general_admin',
        'is_store_admin',
        'store_id'
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
     * Get the user info by user id
     *
     * @param int $id
     *
     * @return App\User
     */
    public function getUserInfoByUserId($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->first();

        return $result;
    }

    /**
     * Get the admin status by user id
     *
     * @param int $id
     *
     * @return App\User
     */
    public function getAdminStatusByUserId($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS_2)
            ->where('id', $id)
            ->first();

        return $result;
    }

    /**
     * Checking of duplicated emails to add
     *
     * @param string $email
     *
     * @return App\User
     */
    public function checkDuplicatedEmailToAdd($email)
    {
        $result = $this->startConditions()
            ->select('id')
            ->where('email', $email)
            ->first();

        return $result;
    }

    /**
     * Checking of duplicated emails to update
     *
     * @param int $id
     * @param string $email
     *
     * @return App\User
     */
    public function checkDuplicatedEmailToUpdate($id, $email)
    {
        $result = $this->startConditions()
            ->select('id')
            ->where('email', $email)
            ->where('id', '!=', $id)
            ->first();

        return $result;
    }

    /**
     * Get the users
     *
     * @return App\User
     */
    public function getAllUsers()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the users with limit
     *
     * @return App\User
     */
    public function getUsersWithLimit()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    /**
     * Seaching of the users
     *
     * @param string $string
     *
     * @return App\User
     */
    public function seachUsers($string)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('name', 'LIKE', '%' . $string . '%')
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Update user info by user id
     *
     * @param int $id
     *            $param array $data
     *            
     * @return void
     */
    public function updateUserInfoByUserId($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    /**
     * Add the user
     *
     * @param array $data
     *
     * @return void
     */
    public function addUser($data)
    {
        $this->startConditions()->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'email_verified_at' => $data['email_verified_at'],
            'is_general_admin' => $data['is_general_admin'],
            'is_store_admin' => $data['is_store_admin'],
            'store_id' => $data['store_id'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Update the user
     *
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function updateUser($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'email_verified_at' => $data['email_verified_at'],
            'is_general_admin' => $data['is_general_admin'],
            'is_store_admin' => $data['is_store_admin'],
            'store_id' => $data['store_id']
        ]);
    }

    /**
     * Update the user without the password
     *
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function updateUserWithoutPass($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => $data['email_verified_at'],
            'is_general_admin' => $data['is_general_admin'],
            'is_store_admin' => $data['is_store_admin'],
            'store_id' => $data['store_id']
        ]);
    }

    /**
     * delete the user
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteUser($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
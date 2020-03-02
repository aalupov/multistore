<?php
namespace App\Repositories;

use App\Models\OrdersStatuses as Model;

/**
 * Class OrdersStatusesRepository
 *
 * @package App\Repositories
 */
class OrdersStatusesRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'order_status'
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
     * Get status order id
     *
     * @param string $order_status
     *
     * @return App\Models\OrdersStatuses
     */
    public function getOrderStatusId($order_status)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('order_status', $order_status)
            ->first();

        return $result;
    }

    /**
     * Get the statuses
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStatuses()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->get();

        return $result;
    }

    /**
     * Get the status name by id
     *
     * @param int $id
     * @return App\Models\OrdersStatuses
     */
    public function getStatusNameById($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->first();

        return $result;
    }
}
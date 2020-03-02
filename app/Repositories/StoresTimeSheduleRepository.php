<?php
namespace App\Repositories;

use App\Models\StoresTimeShedule as Model;

/**
 * Class StoresTimeSheduleRepository
 *
 * @package App\Repositories
 */
class StoresTimeSheduleRepository extends CoreRepository
{

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
     * Check exist store id
     *
     * @param int $store_id
     *
     * @return App\Models\StoresTimeShedule
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
     * add the store id and day of week and time zone
     *
     * @param int $store_id
     * @param int $day
     * @param string $time_zone
     *
     * @return void
     */
    public function addStoreIdAndDayAndTimeZone($store_id, $day, $time_zone)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'day_of_week' => $day,
            'time_zone' => $time_zone,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Add working time range
     *
     * @param int $store_id
     * @param date $opened_at
     * @param date $closed_at
     * @param int $day
     * @param string $time_zone
     *
     * @return void
     */
    public function addTimeRange($store_id, $opened_at, $closed_at, $day, $time_zone)
    {
        $this->startConditions()
            ->where('store_id', $store_id)
            ->where('day_of_week', $day)
            ->update([
            'opened_at' => $opened_at,
            'closed_at' => $closed_at,
            'time_zone' => $time_zone
        ]);
    }
}
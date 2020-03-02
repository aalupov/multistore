<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\CategoryProducts as Model;

/**
 * Class CategoryProductsRepository
 *
 * @package App\Repositories
 */
class CategoryProductsRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'store_id',
        'parent_id',
        'category_name'
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
     * Get store id by category id
     *
     * @param
     *            $id
     *            
     * @return int
     */
    public function getStoreIdByCategoryId($id)
    {
        $result = $this->startConditions()
            ->select('store_id')
            ->where('id', $id)
            ->first()->store_id;

        return $result;
    }

    /**
     * Get all categories for the store
     *
     * @param int $store_id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategoriesForStore($store_id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_id', $store_id)
            ->get();

        return $result;
    }

    /**
     * add the parent caregory
     *
     * @param int $store_id
     * @param string $name
     *
     * @return void
     */
    public function addParentCat($store_id, $name)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'category_name' => $name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * add the child caregory
     *
     * @param int $store_id
     * @param int $parent_id
     * @param string $name
     *
     * @return void
     */
    public function addCategory($store_id, $parent_id, $name)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'parent_id' => $parent_id,
            'category_name' => $name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * delete the category
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteCategory($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }

    /**
     * delete the cheldrens category
     *
     * @param int $parent_id
     *
     * @return void
     */
    public function deleteChildrens($parent_id)
    {
        $this->startConditions()
            ->where('parent_id', $parent_id)
            ->delete();
    }
}
<?php
namespace App\Repositories;

use App\Models\CategoryProductsRelationships as Model;

/**
 * Class CategoryProductsRelationships
 *
 * @package App\Repositories
 */
class CategoryProductsRelationshipsRepository extends CoreRepository
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
     * @return App\Models\Products
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * add the category-product relatioship
     *
     * @param int $store_id
     * @param int $category_id
     * @param int $product_id
     *
     * @return void
     */
    public function addCategoryProductRelatioship($store_id, $category_id, $product_id)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'category_id' => $category_id,
            'product_id' => $product_id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * add the category-product relatioship
     *
     * @param int $store_id
     * @param int $product_id
     *
     * @return void
     */
    public function deleteCategoriesProductRelatioship($store_id, $product_id)
    {
        $this->startConditions()
            ->where('store_id', $store_id)
            ->where('product_id', $product_id)
            ->delete();
    }
}
<?php
namespace App\Repositories;

use App\Models\ValuesAttributesProduct as Model;

/**
 * Class ValuesAttributesProductRepository
 *
 * @package App\Repositories
 */
class ValuesAttributesProductRepository extends CoreRepository
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
     * Get the store id by attribute value id
     *
     * @param int $attribute_value_id
     * @return App\Models\ValuesAttributesProduct
     */
    public function getStoreIdByAttributeValueId($attribute_value_id)
    {
        $result = $this->startConditions()
            ->join('attributes_products', 'attributes_products.id', '=', 'values_attributes_products.attribute_id')
            ->select('attributes_products.store_id')
            ->where('values_attributes_products.id', $attribute_value_id)
            ->first();

        return $result;
    }

    /**
     * add the new attribute value
     *
     * @param int $attribute_id
     * @param string $value
     *
     * @return void
     */
    public function addAttributeValue($attribute_id, $value)
    {
        $this->startConditions()->insert([
            'attribute_id' => $attribute_id,
            'attribute_value' => $value,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Delete the attribute values by attribute id
     *
     * @param int $attribute_id
     *
     * @return void
     */
    public function deleteAttributeValues($attribute_id)
    {
        $this->startConditions()
            ->where('attribute_id', $attribute_id)
            ->delete();
    }

    /**
     * Delete the attribute value
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteAttributeValue($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
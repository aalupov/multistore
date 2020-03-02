<?php
namespace App\Repositories;

use App\Models\Products as Model;

/**
 * Class ProductsRepository
 *
 * @package App\Repositories
 */
class ProductsRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'store_id',
        'product_title',
        'product_sku',
        'product_regular_price',
        'product_sale_price',
        'product_picture',
        'product_description',
        'product_quantity',
        'product_type'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'products.id',
        'products.store_id',
        'stores.store_title',
        'products.product_title',
        'products.product_sku',
        'products.product_regular_price',
        'products.product_sale_price',
        'products.product_picture',
        'products.product_description',
        'products.product_quantity',
        'products.product_type'
    ];

    /**
     * const array
     */
    private const COLUMNS_3 = [
        'category_products_relationships.id',
        'category_products_relationships.store_id',
        'category_products_relationships.category_id',
        'category_products_relationships.product_id',
        'category_products.category_name'
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
     * @return App\Models\Products
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get Product Model
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function checkProduct($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get the product info by product id
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function getProductById($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->with([
            'reviews' => function ($query) {
                $query->where('published', true);
                $query->orderBy('updated_at', 'desc');
            },
            'store_categories_products:id,store_id,category_id,product_id'
        ])
            ->first();

        return $result;
    }

    /**
     * Get the product picture by product id
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function getCurrentPicture($id)
    {
        $result = $this->startConditions()
            ->select('product_picture')
            ->where('id', $id)
            ->first();

        return $result;
    }

    /**
     * Get the products by store id for store panel page
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_id', $store_id)
            ->with([
            'store_categories_products' => function ($query) {
                $query->join('category_products', 'category_products.id', '=', 'category_products_relationships.category_id');
                $query->select(self::COLUMNS_3);
            }
        ])
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Seaching the products for store panel page
     *
     * @param int $store_id
     * @param string $key
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function seachProductsByForStorePanel($store_id, $key)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('store_id', $store_id)
            ->where('product_title', 'LIKE', '%' . $key . '%')
            ->with([
            'store_categories_products' => function ($query) {
                $query->join('category_products', 'category_products.id', '=', 'category_products_relationships.category_id');
                $query->select(self::COLUMNS_3);
            }
        ])
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the product by id to edit
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function getProductByIdToEdit($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->where('id', $id)
            ->with([
            'store_categories_products' => function ($query) {
                $query->join('category_products', 'category_products.id', '=', 'category_products_relationships.category_id');
                $query->select(self::COLUMNS_3);
            }
        ])
            ->first();

        return $result;
    }

    /**
     * Get the products for the searching by key
     *
     * @param string $key
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByKey($key)
    {
        $result = $this->startConditions()
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->select(self::COLUMNS_2)
            ->where('products.product_title', 'LIKE', '%' . $key . '%')
            ->where('products.product_quantity', '!=', 0)
            ->with([
            'reviews:id,store_id,product_id,rating'
        ])
            ->get();

        return $result;
    }

    /**
     * Get the variable products for the store
     *
     * @param int $store_id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getVariableProducts($store_id)
    {
        $result = $this->startConditions()
            ->select('id', 'product_title')
            ->where('product_type', 'variable')
            ->where('store_id', $store_id)
            ->get();

        return $result;
    }

    /**
     * Get quantity and name of the product by product id
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function getQtyAndNameProductById($id)
    {
        $result = $this->startConditions()
            ->select([
            'product_title',
            'product_quantity'
        ])
            ->where('id', $id)
            ->first();

        return $result;
    }

    /**
     * Get store id by product id
     *
     * @param int $id
     *
     * @return App\Models\Products
     */
    public function getStoreIdByProductId($id)
    {
        $result = $this->startConditions()
            ->select([
            'store_id'
        ])
            ->where('id', $id)
            ->first();

        return $result;
    }

    /**
     * Update quantity to the product
     *
     * @param int $id
     *            $param int $product_quantity
     *            
     * @return void
     */
    public function updateQtyProduct($id, $product_quantity)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'product_quantity' => $product_quantity
        ]);
    }

    /**
     * add the product
     *
     * @param array $data
     *
     * @return int $result
     */
    public function addProduct($data)
    {
        $result = $this->startConditions()->insertGetId([
            'store_id' => $data['store_id'],
            'product_title' => $data['product_title'],
            'product_sku' => $data['product_sku'],
            'product_description' => $data['product_description'],
            'product_regular_price' => $data['product_regular_price'],
            'product_sale_price' => $data['product_sale_price'],
            'product_quantity' => $data['product_quantity'],
            'product_type' => $data['product_type'],
            'product_picture' => $data['product_picture'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return $result;
    }

    /**
     * update the product
     *
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function updateProduct($id, $data)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'store_id' => $data['store_id'],
            'product_title' => $data['product_title'],
            'product_sku' => $data['product_sku'],
            'product_description' => $data['product_description'],
            'product_regular_price' => $data['product_regular_price'],
            'product_sale_price' => $data['product_sale_price'],
            'product_quantity' => $data['product_quantity'],
            'product_type' => $data['product_type'],
            'product_picture' => $data['product_picture']
        ]);
    }

    /**
     * Delete the product
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteProduct($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
<?php
namespace App\Repositories;

use App\Models\ReviewsProduct as Model;

/**
 * Class ReviewsProductRepository
 *
 * @package App\Repositories
 */
class ReviewsProductRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'reviews_products.id',
        'reviews_products.store_id',
        'reviews_products.product_id',
        'reviews_products.customer_name',
        'reviews_products.customer_email',
        'reviews_products.review',
        'reviews_products.published',
        'reviews_products.updated_at',
        'products.product_title'
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
     * Get store id by review id
     *
     * @param int $id
     *
     * @return App\Models\ReviewsProduct
     */
    public function getStoreIdByReviewId($id)
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
     * Get the all reviews by store id
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getReviewsByStoreId($store_id)
    {
        $result = $this->startConditions()
            ->join('products', 'products.id', '=', 'reviews_products.product_id')
            ->select(self::COLUMNS)
            ->where('reviews_products.store_id', $store_id)
            ->orderBy('reviews_products.id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the all reviews by store id with limit
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getReviewsByStoreIdWithLimit($store_id)
    {
        $result = $this->startConditions()
            ->join('products', 'products.id', '=', 'reviews_products.product_id')
            ->select(self::COLUMNS)
            ->where('reviews_products.store_id', $store_id)
            ->orderBy('reviews_products.id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    /**
     * add the new review to product
     *
     * @param array $data
     * @param int $product_id
     *
     * @return void
     */
    public function addNewReview($data, $product_id)
    {
        $this->startConditions()->insert([
            'store_id' => $data['store_id'],
            'product_id' => $product_id,
            'customer_name' => $data['author'],
            'customer_email' => $data['email'],
            'review' => $data['comment'],
            'rating' => $data['rating'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Publishe the review
     *
     * @param int $id
     *
     * @return void
     */
    public function publisheReview($id)
    {
        $this->startConditions()
            ->where('id', $id)
            ->update([
            'published' => true
        ]);
    }

    /**
     * Delete the review
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteReview($id)
    {
        $this->startConditions()
            ->find($id)
            ->delete();
    }
}
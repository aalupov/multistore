<?php
namespace App\Repositories;

use App\Models\OrdersComments as Model;

/**
 * Class OrdersCommentsRepository
 *
 * @package App\Repositories
 */
class OrdersCommentsRepository extends CoreRepository
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
     * add the comment to the order
     *
     * @param int $order_id
     * @param string $comment
     *
     * @return void
     */
    public function addCommentToOrder($order_id, $comment)
    {
        $this->startConditions()->insert([
            'order_id' => $order_id,
            'order_comment' => $comment,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * add the comment to the order for the store
     *
     * @param int $order_id
     * @param int $store_id
     * @param string $comment
     *
     * @return void
     */
    public function addCommentToOrderForStore($order_id, $store_id, $comment)
    {
        $this->startConditions()->insert([
            'store_id' => $store_id,
            'order_id' => $order_id,
            'order_comment' => $comment,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
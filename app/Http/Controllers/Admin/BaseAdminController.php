<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\StoresSocialLinksRepository;
use App\Repositories\StoresTimeSheduleRepository;
use App\Repositories\CategoryProductsRelationshipsRepository;
use App\Repositories\ValuesAttributesProductRepository;
use App\Mail\CommentOrderMailSend;
use Illuminate\Support\Facades\Mail;

abstract class BaseAdminController extends BaseController
{

    /**
     * const integer
     */
    protected const PAGINATE = 10;

    /**
     * const array
     */
    protected const viewShareVarsAdminPanel = [
        'userInfo',
        'nameOfPage',
        'total',
        'users',
        'stores',
        'orders'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanel = [
        'id',
        'userInfo',
        'nameOfPage',
        'orders',
        'reviews'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelAddProduct = [
        'id',
        'userInfo',
        'nameOfPage',
        'sortedCategories'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelEditProduct = [
        'id',
        'userInfo',
        'nameOfPage',
        'sortedCategories',
        'product'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelStore = [
        'id',
        'userInfo',
        'nameOfPage',
        'storeInfo'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelCategoies = [
        'id',
        'userInfo',
        'nameOfPage',
        'categories',
        'sortedCategories'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelAttributes = [
        'id',
        'userInfo',
        'nameOfPage',
        'products',
        'attributes',
        'paginatedAttributes'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelProducts = [
        'id',
        'userInfo',
        'nameOfPage',
        'products'
    ];
    
    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelReviews = [
        'id',
        'userInfo',
        'nameOfPage',
        'reviews'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelOrders = [
        'id',
        'userInfo',
        'nameOfPage',
        'orders'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelSettings = [
        'userInfo',
        'nameOfPage',
        'apiKeyAndCountry'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelStores = [
        'userInfo',
        'nameOfPage',
        'stores'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelUsers = [
        'userInfo',
        'nameOfPage',
        'users'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelOrders = [
        'userInfo',
        'nameOfPage',
        'orders'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelOrder = [
        'id',
        'userInfo',
        'nameOfPage',
        'order',
        'products',
        'statuses'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminStorePanelOrder = [
        'id',
        'userInfo',
        'nameOfPage',
        'order',
        'products'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelAddUser = [
        'userInfo',
        'nameOfPage',
        'stores'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelEditUser = [
        'id',
        'userInfo',
        'nameOfPage',
        'stores'
    ];

    /**
     * const array
     */
    protected const viewShareVarsAdminPanelStore = [
        'id',
        'userInfo',
        'nameOfPage',
        'storeInfo'
    ];

    /**
     * BaseAdminController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->StoresSocialLinksRepository = app(StoresSocialLinksRepository::class);
        $this->StoresTimeSheduleRepository = app(StoresTimeSheduleRepository::class);
        $this->CategoryProductsRelationshipsRepository = app(CategoryProductsRelationshipsRepository::class);
        $this->ValuesAttributesProductRepository = app(ValuesAttributesProductRepository::class);
    }

    /**
     * Check the store admin status
     *
     * @param int $storeId
     * @param App\User $userInfo
     *
     * @return boolean
     */
    protected function checkStoreAdminStatus($storeId, $userInfo)
    {
        if ($userInfo->store_id == $storeId) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Convert Date for store shedule
     *
     * @param string $time
     *
     * @return date
     */
    protected function converDateForShedule($time)
    {
        return '1970-01-01 ' . $time . ':00';
    }

    /**
     * Removing the orders from other stores
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Collection $collection
     */
    protected function removeOrders($collection)
    {
        foreach ($collection as $id => $item) {
            if ($item->products->isEmpty()) {
                $collection->forget($id);
            }
        }
        return $collection;
    }

    /**
     * send the comment order email to the customer from admin.
     *
     * @param array $data
     * @param int $orderId
     *
     * @return void
     */
    protected function sendCommentOrderEmail($comment, $orderId)
    {
        $orderInfo = $this->OrdersRepository->getUserIdAndOrderNumberByOrderId($orderId);

        $objMailSend = new \stdClass();
        $objMailSend->sender_message = $comment;
        $objMailSend->date = \Carbon\Carbon::now();
        $objMailSend->order_id = $orderId;
        $objMailSend->order_number = $orderInfo->order_number;
        $objMailSend->sender_email = env('MAIL_FROM_ADDRESS', 'demo@multistore.com');
        $objMailSend->sender_name = env('MAIL_FROM_NAME', 'Laravel');

        if ($orderInfo->user_id != 0) {
            $userInfo = $this->UserRepository->getUserInfoByUserId($orderInfo->user_id);
            $objMailSend->receiver_name = $userInfo->name;
            $mailTo = $userInfo->email;
        } else {
            $userInfo = $this->OrdersAddressesRepository->getUserEmailAndUserNameByOrderId($orderId);
            $objMailSend->receiver_name = $userInfo->first_name . ' ' . $userInfo->last_name;
            $mailTo = $userInfo->email;
        }
        Mail::to($mailTo)->send(new CommentOrderMailSend($objMailSend));
    }

    /**
     * send the comment order email to the customer from store.
     *
     * @param int $storeId
     * @param string $data
     * @param int $orderId
     *
     * @return void
     */
    protected function sendCommentOrderEmailFromStore($storeId, $comment, $orderId)
    {
        $orderInfo = $this->OrdersRepository->getUserIdAndOrderNumberByOrderId($orderId);
        $storeInfo = $this->StoresRepository->getStoreEmailAndStoreNameByStoreId($storeId);

        $objMailSend = new \stdClass();
        $objMailSend->sender_message = $comment;
        $objMailSend->date = \Carbon\Carbon::now();
        $objMailSend->order_id = $orderId;
        $objMailSend->order_number = $orderInfo->order_number;
        $objMailSend->sender_email = $storeInfo->store_email;
        $objMailSend->sender_name = $storeInfo->store_title;

        if ($orderInfo->user_id != 0) {
            $userInfo = $this->UserRepository->getUserInfoByUserId($orderInfo->user_id);
            $objMailSend->receiver_name = $userInfo->name;
            $mailTo = $userInfo->email;
        } else {
            $userInfo = $this->OrdersAddressesRepository->getUserEmailAndUserNameByOrderId($orderId);
            $objMailSend->receiver_name = $userInfo->first_name . ' ' . $userInfo->last_name;
            $mailTo = $userInfo->email;
        }
        Mail::to($mailTo)->send(new CommentOrderMailSend($objMailSend));
    }
}
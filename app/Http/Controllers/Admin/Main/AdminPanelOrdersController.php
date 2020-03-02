<?php
namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminPanelOrdersRequest;

class AdminPanelOrdersController extends BaseAdminController
{

    /**
     * AdminPanelOrdersController constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware([
            'auth',
            'verified',
            'admin'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $nameOfPage = 'Orders Page';
        $orders = $this->OrdersRepository->getOrders();
        $ordersGuests = $this->OrdersRepository->getOrdersForGuests();
        $orders = $this->paginateCollection($orders->merge($ordersGuests)
            ->sortByDesc('id'), self::PAGINATE);

        return view('admin.orders', compact(self::viewShareVarsAdminPanelOrders));
    }

    /**
     * Seaching the order 
     *
     * @param App\Http\Requests\Admin\AdminPanelOrdersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function seachOrder(AdminPanelOrdersRequest $request)
    {
        if (! empty($request->input('find_order'))) {
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $nameOfPage = 'Orders Page';
            $orders = $this->OrdersRepository->seachOrderByNumber($request->input('find_order'));
            foreach ($orders as $order) {
                if ($order->user_id != 0) {
                    $order->name = $this->UserRepository->getUserInfoByUserId($order->user_id)->name;
                }
            }
            $orders = $this->paginateCollection($orders->sortByDesc('id'), self::PAGINATE);

            return view('admin.orders', compact(self::viewShareVarsAdminPanelOrders));
        } else {
            return redirect()->back()
                ->withErrors('The seaching string is empty.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $nameOfPage = 'View Order';
        $order = $this->OrdersRepository->getOrderByOrderId($id);
        $products = $this->convertProductsForOrderPage($order->products, $order->attributes_values);
        $statuses = $this->OrdersStatusesRepository->getStatuses();

        return view('admin.order.view', compact(self::viewShareVarsAdminPanelOrder));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelOrdersRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPanelOrdersRequest $request, $id)
    {
        $this->OrdersRepository->updateStatusOrder($id, $request->input('status'));        
        $orderStatusName = $this->OrdersStatusesRepository->getStatusNameById($request->input('status'))->order_status;
        $string = 'The status order has been changed to ' .$orderStatusName.' by general admin';
        $this->OrdersCommentsRepository->addCommentToOrder($id, $string);
        //send email to the customer
        $this->sendCommentOrderEmail($string, $id);

        if ($request->input('comment') != NULL) {
            $this->OrdersCommentsRepository->addCommentToOrder($id, $request->input('comment'));
            //send email to the customer
            $this->sendCommentOrderEmail($request->input('comment'), $id);
        }

        return redirect()->back()->with('success', 'The order has been updated');
    }
}

<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Store\StorePanelOrdersRequest;

class StorePanelOrdersController extends BaseAdminController
{

    /**
     * StorePanelOrdersController constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth',
            'verified',
            'store.admin'
        ]);
    }

    /**
     * Seaching the order
     *
     * @param App\Http\Requests\Admin\Store\StorePanelOrdersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function seachOrderForStore(StorePanelOrdersRequest $request)
    {
        if (! empty($request->input('find_order'))) {
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $storeId = $userInfo->store_id;
            $nameOfPage = 'Orders Page';
            $orders = $this->removeOrders($this->OrdersRepository->seachOrderByNumberForStore($storeId, $request->input('find_order')));
            foreach ($orders as $order) {
                if ($order->user_id != 0) {
                    $order->name = $this->UserRepository->getUserInfoByUserId($order->user_id)->name;
                }
            }
            $orders = $this->paginateCollection($orders->sortByDesc('id'), self::PAGINATE);
            $id = $storeId;

            return view('admin.stores.orders', compact(self::viewShareVarsAdminStorePanelOrders));
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
        if ($this->StoresRepository->getEdit($id)) {

            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            if (! $this->checkStoreAdminStatus($id, $userInfo)) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
            }
            $nameOfPage = 'Orders Page';
            $orders = $this->removeOrders($this->OrdersRepository->getOrdersByStoreId($id));
            $ordersGuests = $this->removeOrders($this->OrdersRepository->getOrdersForGuestsByStoreId($id));
            $orders = $this->paginateCollection($orders->merge($ordersGuests)
                ->sortByDesc('id'), self::PAGINATE);

            return view('admin.stores.orders', compact(self::viewShareVarsAdminStorePanelOrders));
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! $this->OrdersRepository->getEdit($id)) {
            return redirect()->back()->withErrors('This order does not exist.');
        }

        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $storeId = $userInfo->store_id;
        $nameOfPage = 'Order View Page';
        $order = $this->OrdersRepository->getOrderByOrderIdAndStoreId($id, $storeId);
        $products = $this->convertProductsForOrderPage($order->products, $order->attributes_values);
        $id = $storeId;

        return view('admin.stores.order.view', compact(self::viewShareVarsAdminStorePanelOrder));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelOrdersRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePanelOrdersRequest $request, $id)
    {
        if ($request->input('comment') != NULL) {
            $storeId = $this->UserRepository->getUserInfoByUserId(Auth::user()->id)->store_id;
            // save the comment
            $this->OrdersCommentsRepository->addCommentToOrderForStore($id, $storeId, $request->input('comment'));
            // send email to the customer
            $this->sendCommentOrderEmailFromStore($storeId, $request->input('comment'), $id);
        }

        return redirect()->back()->with('success', 'The order has been updated');
    }
}

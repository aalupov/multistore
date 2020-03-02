<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomePanelController extends BaseAdminController
{

    /**
     * HomePanelController constructor
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if (! $this->checkStoreAdminStatus($id, $userInfo)) {
            return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
        }
        $nameOfPage = 'Dashboard';
        $orders = $this->removeOrders($this->OrdersRepository->getOrdersWithLimitByStoreId($id));
        $reviews = $this->ReviewsProductRepository->getReviewsByStoreIdWithLimit($id);

        return view('admin.stores.main', compact(self::viewShareVarsAdminStorePanel));
    }
}

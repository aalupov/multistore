<?php
namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminPanelController extends BaseAdminController
{

    /**
     * AdminPanelController constructor
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
        $nameOfPage = 'Dashboard';
        $total = $this->OrdersRepository->sumTotalAmount();
        $users = $this->UserRepository->getUsersWithLimit();
        $stores = $this->StoresRepository->getStoresWithLimit();
        $orders = $this->OrdersRepository->getOrdersWithLimit();

        return view('admin.main', compact(self::viewShareVarsAdminPanel));
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware([
            'auth',
            'verified'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalInCart = $this->getGrandTotalInCart();
        $adminStatus = false;
        $adminStoreStatus = true;
        if ($this->UserRepository->getAdminStatusByUserId(Auth::user()->id)->is_general_admin) {
            $adminStatus = true;
        }
        
        $checkStoreAdmin = $this->UserRepository->getAdminStatusByUserId(Auth::user()->id);
        if (! ($checkStoreAdmin->is_store_admin) || $checkStoreAdmin->store_id == 0) {
            $adminStoreStatus = false;         
        }

        return view('home', compact([
            'totalInCart',
            'adminStatus',
            'adminStoreStatus',
            'checkStoreAdmin'
        ]));
    }
}

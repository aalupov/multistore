<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AddressesController extends BaseController
{

    /**
     * AddressesController constructor
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $totalInCart = $this->getGrandTotalInCart();
        $addresses = $this->paginateCollection($this->UserAddressesRepository->getAddressesByUserId($id), self::PAGINATE);

        return view('user.addresses', compact([
            'addresses',
            'totalInCart'
        ]));
    }
}

<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class OrderController extends BaseController
{

    /**
     * OrderController constructor
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
        return view('user.order', $this->createUserOrderPage($id));
    }
}

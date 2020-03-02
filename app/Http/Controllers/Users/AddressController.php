<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserAddressRequest;
use Illuminate\Support\Facades\Auth;

class AddressController extends BaseController
{

    /**
     * AddressController constructor
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $totalInCart = $this->getGrandTotalInCart();
        return view('user.address.create', compact('totalInCart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\UserAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddressRequest $request)
    {
        if (! ($this->validEmail($request->input('email')))) {
            return redirect()->back()
                ->withErrors('The Email must be a valid email address.')
                ->withInput();
        }
        $userId = Auth::user()->id;
        $address = $request->input();
        $this->UserAddressesRepository->addAddressToUser($userId, $address);

        return redirect()->route('addressesUser.show', $userId)->with('success', 'The address has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->UserAddressesRepository->getEdit($id)) {

            $totalInCart = $this->getGrandTotalInCart();
            $address = $this->UserAddressesRepository->getAddressById($id);

            return view('user.address.edit', compact([
                'address',
                'totalInCart'
            ]));
        } else {
            return redirect()->back()->withErrors('This address does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\UserAddressRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserAddressRequest $request, $id)
    {
        if (! ($this->validEmail($request->input('email')))) {
            return redirect()->back()
                ->withErrors('The Email must be a valid email address.')
                ->withInput();
        }
        $userId = Auth::user()->id;
        $address = $request->input();
        $this->UserAddressesRepository->updateAddressToUser($id, $address);

        return redirect()->route('addressesUser.show', $userId)->with('success', 'The address has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->UserAddressesRepository->getEdit($id)) {
            $this->UserAddressesRepository->deleteAddress($id);

            return redirect()->back()->with('success', 'The address has been removed successfully');
        } else {
            return redirect()->back()->withErrors('This address does not exist.');
        }
    }
}

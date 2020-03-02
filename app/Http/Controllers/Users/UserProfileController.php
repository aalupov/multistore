<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends BaseController
{

    /**
     * UserProfileController constructor
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.profile', $this->profileEditPage($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (! ($this->validEmail($request->input('email')))) {
            return redirect()->back()
                ->withErrors('The email must be a valid email address.')
                ->withInput();
        }

        if ($this->UserRepository->checkDuplicatedEmailToUpdate($id, $request->input('email')) != null) {
            return redirect()->back()
                ->withErrors('The User with such email is exist already')
                ->withInput();
        }

        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = Hash::make($request->input('password'));

        $this->UserRepository->updateUserInfoByUserId($id, $data);

        return redirect()->back()->with('success', 'The profile has been updated. Thank you!');
    }
}

<?php
namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminPanelUsersRequest;
use Illuminate\Support\Facades\Hash;

class AdminPanelUsersController extends BaseAdminController
{

    /**
     * AdminPanelUsersController constructor
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
        $nameOfPage = 'Customers Page';
        $users = $this->paginateCollection($this->UserRepository->getAllUsers(), self::PAGINATE);

        return view('admin.users', compact(self::viewShareVarsAdminPanelUsers));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $nameOfPage = 'Add Customer';
        $stores = $this->StoresRepository->getAllStores();

        return view('admin.user.add', compact(self::viewShareVarsAdminPanelAddUser));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPanelUsersRequest $request)
    {
        if (! empty($request->input('email'))) {
            if (! ($this->validEmail($request->input('email')))) {
                return redirect()->back()
                    ->withErrors('The User Email must be a valid email address.')
                    ->withInput();
            }

            if ($this->UserRepository->checkDuplicatedEmailToAdd($request->input('email')) != null) {
                return redirect()->back()
                    ->withErrors('The User with such email is exist already')
                    ->withInput();
            }

            $data = $request->input();
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
            $data['password'] = Hash::make($request->input('password'));

            if ($request->input('is_general_admin')) {
                $data['is_general_admin'] = true;
            } else {
                $data['is_general_admin'] = false;
            }

            if ($request->input('is_store_admin')) {
                $data['is_store_admin'] = true;
                $data['store_id'] = $request->input('selected_store');
            } else {
                $data['is_store_admin'] = false;
                $data['store_id'] = 0;
            }

            if ($request->input('email_verified')) {
                $data['email_verified_at'] = \Carbon\Carbon::now();
            } else {
                $data['email_verified_at'] = NULL;
            }

            $this->UserRepository->addUser($data);

            return redirect()->route('adminUsers.index')->with('success', 'The New User has been added successfully');
        }
    }

    /**
     * Seaching the user.
     *
     * @param App\Http\Requests\Admin\AdminPanelUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function seachUser(AdminPanelUsersRequest $request)
    {
        if (! empty($request->input('find_user'))) {
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $nameOfPage = 'Customers Page';
            $users = $this->paginateCollection($this->UserRepository->seachUsers($request->input('find_user')), self::PAGINATE);

            return view('admin.users', compact(self::viewShareVarsAdminPanelUsers));
        } else {
            return redirect()->back()
                ->withErrors('The seaching string is empty.')
                ->withInput();
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
        if ($this->UserRepository->getEdit($id)) {

            $userInfo = $this->UserRepository->getUserInfoByUserId($id);
            $nameOfPage = 'Edit Customer';
            $stores = $this->StoresRepository->getAllStores();

            return view('admin.user.edit', compact(self::viewShareVarsAdminPanelEditUser));
        } else {
            return redirect()->back()->withErrors('This user does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelUsersRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPanelUsersRequest $request, $id)
    {
        if (! empty($request->input('email'))) {
            if (! ($this->validEmail($request->input('email')))) {
                return redirect()->back()
                    ->withErrors('The User Email must be a valid email address.')
                    ->withInput();
            }
            if ($this->UserRepository->checkDuplicatedEmailToUpdate($id, $request->input('email')) != null) {
                return redirect()->back()
                    ->withErrors('The User with such email is exist already')
                    ->withInput();
            }

            $data = $request->input();

            if ($request->input('is_general_admin')) {
                $data['is_general_admin'] = true;
            } else {
                $data['is_general_admin'] = false;
            }

            if ($request->input('is_store_admin')) {
                $data['is_store_admin'] = true;
                $data['store_id'] = $request->input('selected_store');
            } else {
                $data['is_store_admin'] = false;
                $data['store_id'] = 0;
            }

            if ($request->input('email_verified')) {
                $data['email_verified_at'] = \Carbon\Carbon::now();
            } else {
                $data['email_verified_at'] = NULL;
            }

            if (! empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));

                $this->UserRepository->updateUser($id, $data);
            } else {
                $this->UserRepository->updateUserWithoutPass($id, $data);
            }

            return redirect()->route('adminUsers.index')->with('success', 'The User has been updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->UserRepository->getEdit($id)) {
            $this->UserRepository->deleteUser($id);

            return redirect()->back()->with('success', 'The user has been removed successfully');
        } else {
            return redirect()->back()->withErrors('This user does not exist.');
        }
    }
}

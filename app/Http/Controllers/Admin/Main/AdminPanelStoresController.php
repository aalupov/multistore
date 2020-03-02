<?php
namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminPanelStoresRequest;
use Illuminate\Support\Facades\Storage;

class AdminPanelStoresController extends BaseAdminController
{

    /**
     * AdminPanelStoresController constructor
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
        $nameOfPage = 'Stores Page';
        $stores = $this->paginateCollection($this->StoresRepository->getAllStores(), self::PAGINATE);

        return view('admin.stores', compact(self::viewShareVarsAdminPanelStores));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $nameOfPage = 'Add Store';

        return view('admin.store.add', compact(self::viewShareVarsAdminPanel));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelStoresRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPanelStoresRequest $request)
    {
        if (! empty($request->input('store_email'))) {
            if (! ($this->validEmail($request->input('store_email')))) {
                return redirect()->back()
                    ->withErrors('The Store Email must be a valid email address.')
                    ->withInput();
            }

            $data = $request->input();
            $data['store_picture'] = null;

            if ($request->input('store_is_activated')) {
                $data['store_is_activated'] = true;
            } else {
                $data['store_is_activated'] = false;
            }

            if ($request->hasFile('store_picture')) {
                if ($request->file('store_picture')->isValid()) {

                    $uploadedFile = $request->file('store_picture');
                    $filename = time() . '-' . $uploadedFile->getClientOriginalName();

                    Storage::disk('public')->putFileAs('store/', $uploadedFile, $filename);

                    $data['store_picture'] = $filename;
                }
            }

            $this->StoresRepository->addStore($data);

            return redirect()->route('adminStores.index')->with('success', 'The New Store has been added successfully');
        }
    }

    /**
     * Seaching the store
     *
     * @param App\Http\Requests\Admin\AdminPanelStoresRequest $request
     * @return \Illuminate\Http\Response
     */
    public function seachStore(AdminPanelStoresRequest $request)
    {
        if (! empty($request->input('find_store'))) {
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $nameOfPage = 'Stores Page';
            $stores = $this->paginateCollection($this->StoresRepository->seachStores($request->input('find_store')), self::PAGINATE);

            return view('admin.stores', compact(self::viewShareVarsAdminPanelStores));
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
            $nameOfPage = 'View Store Page';
            $storeInfo = $this->StoresRepository->getEdit($id);

            return view('admin.store.view', compact(self::viewShareVarsAdminPanelStore));
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
        if ($this->StoresRepository->getEdit($id)) {

            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $nameOfPage = 'Edit Store Page';
            $storeInfo = $this->StoresRepository->getEdit($id);

            return view('admin.store.edit', compact(self::viewShareVarsAdminPanelStore));
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelStoresRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPanelStoresRequest $request, $id)
    {
        if (! ($this->validEmail($request->input('store_email')))) {
            return redirect()->back()
                ->withErrors('The Store Email must be a valid email address.')
                ->withInput();
        }

        $data = $request->input();

        if ($request->input('store_is_activated')) {
            $data['store_is_activated'] = true;
        } else {
            $data['store_is_activated'] = false;
        }

        if ($request->hasFile('store_picture')) {
            if ($request->file('store_picture')->isValid()) {

                $uploadedFile = $request->file('store_picture');
                $filename = time() . '-' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs('store/', $uploadedFile, $filename);

                $data['store_picture'] = $filename;

                $this->StoresRepository->updateStore($id, $data);
            }
        } else {
            $this->StoresRepository->updateStoreWithoutPicture($id, $data);
        }

        return redirect()->route('adminStores.index')->with('success', 'The Store has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->StoresRepository->getEdit($id)) {
            $this->StoresRepository->deleteStore($id);

            return redirect()->back()->with('success', 'The store has been removed successfully');
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }
}

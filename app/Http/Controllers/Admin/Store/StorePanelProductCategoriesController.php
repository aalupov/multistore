<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Store\StorePanelProductCategoriesRequest;

class StorePanelProductCategoriesController extends BaseAdminController
{

    /**
     * StorePanelProductCategoriesController constructor
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
        if ($this->StoresRepository->getEdit($id)) {

            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            if (! $this->checkStoreAdminStatus($id, $userInfo)) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
            }
            $nameOfPage = 'Product Categories Page';
            $categories = $this->CategoryProductsRepository->getAllCategoriesForStore($id);
            $sortedCategories = $this->sortCategoriesByChildrens($categories);

            return view('admin.stores.categories', compact(self::viewShareVarsAdminStorePanelCategoies));
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
        if (! $this->CategoryProductsRepository->getEdit($id)) {
            return redirect()->back()->withErrors('This category does not exist.');
        }

        $storeId = $this->CategoryProductsRepository->getStoreIdByCategoryId($id);
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if (! $this->checkStoreAdminStatus($storeId, $userInfo)) {
            return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
        }

        $this->CategoryProductsRepository->deleteCategory($id);
        $this->CategoryProductsRepository->deleteChildrens($id);

        return redirect()->back()->with('success', 'The Category has been removed successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelProductCategoriesRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePanelProductCategoriesRequest $request, $id)
    {
        if ($request->input('selected_parent_cat') == 0) {
            $this->CategoryProductsRepository->addParentCat($id, $request->input('category_name'));

            return redirect()->back()->with('success', 'The Category has been created successfully');
        } else {
            $this->CategoryProductsRepository->addCategory($id, $request->input('selected_parent_cat'), $request->input('category_name'));

            return redirect()->back()->with('success', 'The Category has been created successfully');
        }
    }
}

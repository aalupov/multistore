<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Store\StorePanelAttributesProductRequest;

class StorePanelAttributesProductController extends BaseAdminController
{

    /**
     * StorePanelAttributesProductController constructor
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
            $nameOfPage = 'Product Attributes Page';
            $products = $this->ProductsRepository->getVariableProducts($id);
            $attributes = $this->AttributesProductRepository->getAttributesByStoreId($id);
            $paginatedAttributes = $this->paginateCollection($attributes, self::PAGINATE);

            return view('admin.stores.attributes', compact(self::viewShareVarsAdminStorePanelAttributes));
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
        if (! $this->ValuesAttributesProductRepository->getEdit($id)) {
            return redirect()->back()->withErrors('This attribute value does not exist.');
        }

        $storeId = $this->ValuesAttributesProductRepository->getStoreIdByAttributeValueId($id)->store_id;
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if (! $this->checkStoreAdminStatus($storeId, $userInfo)) {
            return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
        }

        $this->ValuesAttributesProductRepository->deleteAttributeValue($id);

        return redirect()->back()->with('success', 'The Attribute Value has been removed successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelAttributesProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePanelAttributesProductRequest $request, $id)
    {
        if (! $request->input('new_attribute_name') && ! $request->input('attribute_value') && ! $request->input('attribute_to_remove')) {
            return redirect()->back()->withErrors('We did put anything in any field');
        }

        if ($request->input('new_attribute_name') && $request->input('selected_product') && $request->input('attribute_value') && $request->input('selected_attribute')) {

            $this->AttributesProductRepository->addAttribute($id, $request->input('new_attribute_name'), $request->input('selected_product'));
            $this->ValuesAttributesProductRepository->addAttributeValue($request->input('selected_attribute'), $request->input('attribute_value'));

            return redirect()->back()->with('success', 'The Attributes has been added successfully');
        } elseif ($request->input('new_attribute_name') && $request->input('selected_product') && ! $request->input('attribute_value')) {

            $this->AttributesProductRepository->addAttribute($id, $request->input('new_attribute_name'), $request->input('selected_product'));

            return redirect()->back()->with('success', 'The Attribute has been added successfully');
        } elseif (! $request->input('new_attribute_name') && $request->input('attribute_value') && $request->input('selected_attribute')) {

            $this->ValuesAttributesProductRepository->addAttributeValue($request->input('selected_attribute'), $request->input('attribute_value'));

            return redirect()->back()->with('success', 'The Attribute Value has been added successfully');
        } elseif ($request->input('new_attribute_name') && ! $request->input('selected_product')) {
            return redirect()->back()->withErrors('The variable product does not exist.');
        } elseif ($request->input('attribute_value') && ! $request->input('selected_attribute')) {
            return redirect()->back()->withErrors('The attribute value does not exist.');
        }

        if ($request->input('attribute_to_remove')) {
            $this->ValuesAttributesProductRepository->deleteAttributeValues($request->input('attribute_to_remove'));
            $this->AttributesProductRepository->deleteAttribute($request->input('attribute_to_remove'));

            return redirect()->back()->with('success', 'The Attribute has been removed successfully');
        }
    }
}

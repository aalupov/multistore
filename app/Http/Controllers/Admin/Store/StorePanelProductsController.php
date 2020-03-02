<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Store\StorePanelProductsRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StorePanelProductsController extends BaseAdminController
{

    /**
     * StorePanelProductsController constructor
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        $id = $userInfo->store_id;
        $nameOfPage = 'Add Product Page';
        $categories = $this->CategoryProductsRepository->getAllCategoriesForStore($id);
        $sortedCategories = $this->sortCategoriesByChildrens($categories);

        return view('admin.stores.product.add', compact(self::viewShareVarsAdminStorePanelAddProduct));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelProductsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePanelProductsRequest $request)
    {
        if (! empty($request->input('product_title'))) {
            $data = $request->input();
            $data['product_picture'] = null;
            $data['product_sku'] = Str::slug($data['product_title'], '_');
            $data['store_id'] = $this->UserRepository->getUserInfoByUserId(Auth::user()->id)->store_id;
            if (empty($request->input('product_quantity'))) {
                $data['product_quantity'] = 0;
            }

            if ($request->hasFile('product_picture')) {
                if ($request->file('product_picture')->isValid()) {

                    $uploadedFile = $request->file('product_picture');
                    $filename = time() . '-' . $data['store_id'] . '-' . $uploadedFile->getClientOriginalName();

                    Storage::disk('public')->putFileAs('product/', $uploadedFile, $filename);

                    $data['product_picture'] = $filename;
                }
            }

            $productId = $this->ProductsRepository->addProduct($data);

            foreach ($data['product_categories'] as $categoryId) {
                $this->CategoryProductsRelationshipsRepository->addCategoryProductRelatioship($data['store_id'], $categoryId, $productId);
            }

            return redirect()->route('adminStorePanelProduct.show', $data['store_id'])->with('success', 'The Product has been added successfully');
        }
    }

    /**
     * seaching the products.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelProductsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function seachProduct(StorePanelProductsRequest $request)
    {
        if (! empty($request->input('find_product'))) {
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            $nameOfPage = 'Products Page';
            $id = $userInfo->store_id;
            $products = $this->paginateCollection($this->ProductsRepository->seachProductsByForStorePanel($id, $request->input('find_product')), self::PAGINATE);

            return view('admin.stores.products', compact(self::viewShareVarsAdminStorePanelProducts));
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
            if (! $this->checkStoreAdminStatus($id, $userInfo)) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
            }
            $nameOfPage = 'Products Page';
            $products = $this->paginateCollection($this->ProductsRepository->getProductsByStoreId($id), self::PAGINATE);

            return view('admin.stores.products', compact(self::viewShareVarsAdminStorePanelProducts));
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
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if ($this->StoresRepository->getEdit($userInfo->store_id)) {
            $nameOfPage = 'Edit Product Page';
            if ($this->ProductsRepository->getStoreIdByProductId($id)->store_id != $userInfo->store_id) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to remove this product');
            }
            $product = $this->ProductsRepository->getProductByIdToEdit($id);
            $id = $userInfo->store_id;
            $categories = $this->CategoryProductsRepository->getAllCategoriesForStore($id);
            $sortedCategories = $this->sortCategoriesByChildrens($categories, $product->store_categories_products);

            return view('admin.stores.product.edit', compact(self::viewShareVarsAdminStorePanelEditProduct));
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelProductsRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePanelProductsRequest $request, $id)
    {
        if (! empty($request->input('product_title'))) {
            $data = $request->input();
            $data['product_sku'] = Str::slug($data['product_title'], '_');
            $data['store_id'] = $this->UserRepository->getUserInfoByUserId(Auth::user()->id)->store_id;
            if (empty($request->input('product_quantity'))) {
                $data['product_quantity'] = 0;
            }

            if ($request->hasFile('product_picture')) {
                if ($request->file('product_picture')->isValid()) {

                    $uploadedFile = $request->file('product_picture');
                    $filename = time() . '-' . $data['store_id'] . '-' . $uploadedFile->getClientOriginalName();

                    Storage::disk('public')->putFileAs('product/', $uploadedFile, $filename);

                    $data['product_picture'] = $filename;
                }
            }else{
                $data['product_picture'] = $this->ProductsRepository->getCurrentPicture($id)->product_picture;
            }

            $this->ProductsRepository->updateProduct($id, $data);

            $this->CategoryProductsRelationshipsRepository->deleteCategoriesProductRelatioship($data['store_id'], $id);
            foreach ($data['product_categories'] as $categoryId) {
                $this->CategoryProductsRelationshipsRepository->addCategoryProductRelatioship($data['store_id'], $categoryId, $id);
            }

            return redirect()->route('adminStorePanelProduct.show', $data['store_id'])->with('success', 'The Product has been updated successfully');
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
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if ($this->StoresRepository->getEdit($userInfo->store_id)) {
            if ($this->ProductsRepository->getStoreIdByProductId($id)->store_id != $userInfo->store_id) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to remove this product');
            }
            $this->ProductsRepository->deleteProduct($id);

            return redirect()->back()->with('success', 'The product has been removed successfully');
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }
}

<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoresStoreRequest;

class StoresController extends BaseController
{

    /**
     * StoresController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param StoresRepository $stores
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', $this->createStoresPage());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoresStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresStoreRequest $request)
    {
        return view('index', $this->createStoresPage($request));
    }

    /**
     * Seaching of the products.
     *
     * @param \App\Http\Requests\StoresStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function findProducts(StoresStoreRequest $request)
    {
        if ($request->input('find_product')) {
            $findResult = $this->seachProducts($request);
            if (isset($findResult)) {
                return view('seach', $findResult);
            } else {
                return redirect()->back()
                    ->withErrors('Sorry, There are not the such products:(')
                    ->withInput();
            }
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
        $storeInfo = $this->StoresRepository->getStoreInfoById($id);
        if (! $storeInfo->store_is_activated) {
            return redirect()->route('indexStore.index')->withErrors('This Store is deactivated.');
        }

        return view('store.index', $this->createStorePage($storeInfo));
    }

    /**
     * Sort the products by key.
     *
     * @param \App\Http\Requests\StoresStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function sort(StoresStoreRequest $request)
    {
        if ($request->input('orderby')) {
            $key = $request->input('orderby');
            if (! $request->input('category_id')) {
                $id = $request->input('store_id');
                $storeInfo = $this->StoresRepository->getStoreInfoById($id);
                return view('store.index', $this->createStorePage($storeInfo, $key));
            } else {
                $storeId = $request->input('store_id');
                $id = $request->input('category_id');
                return view('store.category', $this->createCategoryPage($storeId, $id, $key));
            }
        }
    }
}

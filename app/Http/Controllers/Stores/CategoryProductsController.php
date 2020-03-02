<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CategoryProductsController extends BaseController
{

    /**
     * CategoryProductsController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storeId = $this->CategoryProductsRepository->getStoreIdByCategoryId($id);

        return view('store.category', $this->createCategoryPage($storeId, $id));
    }
}

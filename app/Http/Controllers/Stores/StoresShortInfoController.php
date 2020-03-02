<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class StoresShortInfoController extends BaseController
{

    /**
     * StoresShortInfoController constructor
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
        $storeInfo = $this->StoresRepository->getStoreInfoById($id);
        $storeInfo->store_status = $this->checkStoreStatus($storeInfo->time_shedule);

        return view('store.info', compact(self::viewShareVarsForShortStoreInfo));
    }
}

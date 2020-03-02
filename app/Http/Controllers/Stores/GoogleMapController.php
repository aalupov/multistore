<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class GoogleMapController extends BaseController
{

    /**
     * GoogleMapController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storeInfo = $this->StoresRepository->getAllActiveStores()->toArray();
        $apiKeyAndCountry = $this->GoogleApiKeyRepository->getApiKeyAndCountryCode();
        if (isset($apiKeyAndCountry)) {
            $geoDataofMultiStore = $this->CountryGeoDataRepository->getGeoDataByCountry($apiKeyAndCountry->country_location);
        } else {
            return redirect()->back();
        }
        $totalInCart = $this->getGrandTotalInCart();

        return view('google.map.index', compact(self::viewShareVarsForGoogleMap));
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
        $apiKeyAndCountry = $this->GoogleApiKeyRepository->getApiKeyAndCountryCode();
        $geoDataofMultiStore = $this->CountryGeoDataRepository->getGeoDataByCountry($apiKeyAndCountry->country_location);
        $totalInCart = $this->getGrandTotalInCart();

        return view('google.map.index_id', compact(self::viewShareVarsForGoogleMap));
    }
}

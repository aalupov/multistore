<?php
namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminPanelSettingsRequest;

class AdminPanelSettingsController extends BaseAdminController
{

    /**
     * AdminPanelSettingsController constructor
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
        $nameOfPage = 'Settings Page';
        $apiKeyAndCountry = $this->GoogleApiKeyRepository->getApiKeyAndCountryCode();

        return view('admin.settings', compact(self::viewShareVarsAdminPanelSettings));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Admin\AdminPanelSettingsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPanelSettingsRequest $request)
    {
        if ($this->GoogleApiKeyRepository->getApiKeyAndCountryCode() != NULL) {
            $this->GoogleApiKeyRepository->updateApiKeyAndCountryCode($request->input());
        } else {
            $this->GoogleApiKeyRepository->insertApiKeyAndCountryCode($request->input());
        }

        return redirect()->back()->with('success', 'The Api Key has been saved successfully.');
    }
}

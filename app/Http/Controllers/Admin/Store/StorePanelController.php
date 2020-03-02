<?php
namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Store\StorePanelRequest;

class StorePanelController extends BaseAdminController
{

    /**
     * StorePanelController constructor
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
            $nameOfPage = 'View Store Page';
            $storeInfo = $this->StoresRepository->getStoreInfoByIdWithShedule($id);
            $this->convertDateToHourMinute($storeInfo->time_shedule);

            return view('admin.stores.store.view', compact(self::viewShareVarsAdminStorePanelStore));
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
            if (! $this->checkStoreAdminStatus($id, $userInfo)) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
            }
            $nameOfPage = 'Edit Store Page';
            $storeInfo = $this->StoresRepository->getStoreInfoByIdWithShedule($id);
            $this->convertDateToHourMinuteForStoreEdit($storeInfo->time_shedule);

            return view('admin.stores.store.edit', compact(self::viewShareVarsAdminStorePanelStore));
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Admin\Store\StorePanelRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePanelRequest $request, $id)
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

        // add social links
        if (! $this->StoresSocialLinksRepository->checkStoreId($id)) {
            $this->StoresSocialLinksRepository->addStoreId($id);
        }
        if (! empty($request->input('store_twitter'))) {
            $this->StoresSocialLinksRepository->addTwitter($id, $request->input('store_twitter'));
        }
        if (! empty($request->input('store_instagram'))) {
            $this->StoresSocialLinksRepository->addInstagram($id, $request->input('store_instagram'));
        }
        if (! empty($request->input('store_facebook'))) {
            $this->StoresSocialLinksRepository->addFacebook($id, $request->input('store_facebook'));
        }

        // add time shedule
        if ($this->StoresTimeSheduleRepository->checkStoreId($id) == NULL) {
            for ($i = 1; $i <= 7; $i ++) {
                $this->StoresTimeSheduleRepository->addStoreIdAndDayAndTimeZone($id, $i, $request->input('time_zone'));
            }
        }
        if ($request->input('monday_work') == 1 && $request->input('monday_from') != NULL && $request->input('monday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('monday_from')), $this->converDateForShedule($request->input('monday_to')), 1, $request->input('time_zone'));
        }elseif ($request->input('monday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 1, $request->input('time_zone'));
        }
        if ($request->input('tuesday_work') == 1 && $request->input('tuesday_from') != NULL && $request->input('tuesday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('tuesday_from')), $this->converDateForShedule($request->input('tuesday_to')), 2, $request->input('time_zone'));
        }elseif ($request->input('tuesday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 2, $request->input('time_zone'));
        }
        if ($request->input('wednesday_work') == 1 && $request->input('wednesday_from') != NULL && $request->input('wednesday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('wednesday_from')), $this->converDateForShedule($request->input('wednesday_to')), 3, $request->input('time_zone'));
        }elseif ($request->input('wednesday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 3, $request->input('time_zone'));
        }
        if ($request->input('thursday_work') == 1 && $request->input('thursday_from') != NULL && $request->input('thursday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('thursday_from')), $this->converDateForShedule($request->input('thursday_to')), 4, $request->input('time_zone'));
        }elseif ($request->input('thursday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 4, $request->input('time_zone'));
        }
        if ($request->input('friday_work') == 1 && $request->input('friday_from') != NULL && $request->input('friday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('friday_from')), $this->converDateForShedule($request->input('friday_to')), 5, $request->input('time_zone'));
        }elseif ($request->input('friday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 5, $request->input('time_zone'));
        }
        if ($request->input('saturday_work') == 1 && $request->input('saturday_from') != NULL && $request->input('saturday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('saturday_from')), $this->converDateForShedule($request->input('saturday_to')), 6, $request->input('time_zone'));
        }elseif ($request->input('saturday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 6, $request->input('time_zone'));
        }
        if ($request->input('sunday_work') == 1 && $request->input('sunday_from') != NULL && $request->input('sunday_to') != NULL) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, $this->converDateForShedule($request->input('sunday_from')), $this->converDateForShedule($request->input('sunday_to')), 7, $request->input('time_zone'));
        }elseif ($request->input('sunday_work') == 0) {
            $this->StoresTimeSheduleRepository->addTimeRange($id, NULL, NULL, 7, $request->input('time_zone'));
        }

        return redirect()->route('adminStorePanel.show', $id)->with('success', 'The Store has been updated successfully');
    }
}

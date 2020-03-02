<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StorePanelReviewsController extends BaseAdminController
{
    
    /**
     * StorePanelReviewsController constructor
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->StoresRepository->getEdit($id)) {
            
            $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
            if (! $this->checkStoreAdminStatus($id, $userInfo)) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
            }
            $nameOfPage = 'Reviews Page';
            $reviews = $this->paginateCollection($this->ReviewsProductRepository->getReviewsByStoreId($id), self::PAGINATE);
            
            return view('admin.stores.reviews', compact(self::viewShareVarsAdminStorePanelReviews));
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if ($this->StoresRepository->getEdit($userInfo->store_id)) {
            if ($this->ReviewsProductRepository->getStoreIdByReviewId($id)->store_id != $userInfo->store_id) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to remove this review');
            }
            $this->ReviewsProductRepository->publisheReview($id);
            
            return redirect()->back()->with('success', 'The review has been published successfully');
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId(Auth::user()->id);
        if ($this->StoresRepository->getEdit($userInfo->store_id)) {
            if ($this->ReviewsProductRepository->getStoreIdByReviewId($id)->store_id != $userInfo->store_id) {
                return redirect()->route('home')->withErrors('Sorry, We have not privileges to remove this review');
            }
            $this->ReviewsProductRepository->deleteReview($id);
            
            return redirect()->back()->with('success', 'The review has been removed successfully');
        } else {
            return redirect()->back()->withErrors('This store does not exist.');
        }
    }
}

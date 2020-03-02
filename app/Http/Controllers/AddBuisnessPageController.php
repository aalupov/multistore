<?php
namespace App\Http\Controllers;

use App\Http\Requests\AddBuisnessPageRequest;
use Illuminate\Support\Facades\Storage;

class AddBuisnessPageController extends BaseController
{

    /**
     * AddBuisnessPageController constructor
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
        $totalInCart = $this->getGrandTotalInCart();

        return view('addbuisness', compact([
            'totalInCart'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\AddBuisnessPageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddBuisnessPageRequest $request)
    {
        if (! ($this->validEmail($request->input('store_email')))) {
            return redirect()->back()
                ->withErrors('The Email must be a valid email address.')
                ->withInput();
        }

        $data = $request->input();

        if ($request->hasFile('store_picture')) {
            if ($request->file('store_picture')->isValid()) {

                $uploadedFile = $request->file('store_picture');
                $filename = time() . '-' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs('store/', $uploadedFile, $filename);

                $data['store_picture'] = \URL::to('/upload/store/' . $filename);
            }
        }

        $this->sendAddBuisnessEmail($data);

        return redirect()->back()->with('success', 'We have received the emal from you. Thank you!.');
    }
}

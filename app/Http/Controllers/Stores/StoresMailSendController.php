<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use App\Mail\StoresMailSend;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoresMailSendRequest;

class StoresMailSendController extends BaseController
{

    /**
     * send email from contact form of the store page.
     *
     * @param App\Http\Requests\StoresMailSendRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function send(StoresMailSendRequest $request)
    {
        if (! empty($request->input('store-contact-form'))) {

            if (! ($this->validEmail($request->input('email')))) {
                return redirect()->back()
                    ->withErrors('The email must be a valid email address.')
                    ->withInput();
            }

            $objStoreMailSend = new \stdClass();
            $objStoreMailSend->sender_message = $request->input('message');
            $objStoreMailSend->sender_email = $request->input('email');
            $objStoreMailSend->sender_name = $request->input('name');
            $objStoreMailSend->sender_phone = $request->input('phone');
            $objStoreMailSend->receiver_name = $request->input('receiver_name');

            Mail::to($request->input('receiver_email'))->send(new StoresMailSend($objStoreMailSend));

            return redirect()->back()->with('success', 'Your message has been sent. Thank you!');
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
        return view('store.contact', $this->createContactPage($id));
    }
}
<?php

namespace App\Http\Controllers;


use HelloSign\Client;
use Illuminate\View\View;
use HelloSign\SignatureRequest;
use HelloSign\EmbeddedSignatureRequest;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{


    /**
     * @return View
     */
    public function index (): View
    {
        return view ('layouts.home', $this->data);
    }

    public function hellosign ()
    {
        $client = new Client('7ca9d3745628cf93e93ec9c1d1a159688b7d6a23f74d2780b990879fc3e061d8');

        $request = new SignatureRequest();
        $request->enableTestMode ();
        $request->setTitle ('test');
        $request->setSubject ('test');
        $request->setMessage ('test');
//        $request->setSignerOptions ()
//        $request->addGroupSigner ( 'Jack1','muhammad2.h.alali@gmail.com',0);
        $request->addSigner ('muhammad2.h.alali@gmail.com', 'Jack2');
//        $request->addSigner ('muhammad4.h.alali@gmail.com', 'Jack3');
//        $request->setCustomFieldValue('Client Address', '123 Main St, Anytown, ST 12345');
//        $request->setUseTextTags(true);
//        $request->setHideTextTags(true);
        $request->addFile ('C:\xampp\htdocs\erp_laravel_6\public\file\invoice\texttags_example.pdf');
        $embedded_request = new EmbeddedSignatureRequest($request, '182bea059aeffb6a3e00329e8376fda0');
        $response = $client->createEmbeddedSignatureRequest ($embedded_request);

        // At this point you should save the signature request id.
        // Get it like this:
        $signature_request_id = $response->getId ();

        // In order to actually show the request, you need the signature
        // id of the person who needs to sign.

        // First, get a list of all signers.
        $signatures = $response->getSignatures ();

        // Then, get the "Student" signature id.
        $signature_id = $signatures[0]->getId ();
//        $signature_request = $client->getSignatureRequest ($signature_request_id);
//
//        if ($signature_request->isComplete ()) {
////            return Redirect::action ('StudentController@getIndex')
////                ->withErrors (array(
////                    'message' => 'This agreement has already been signed.'
////                ));
//        }


// Retrieve the URL to sign the document.
// This will be used in the javascript.
        $response = $client->getEmbeddedSignUrl ($signature_id);
        $sign_url = $response->getSignUrl ();

//        print_r ($response['']);
//echo $sign_url;
//        echo $sign_url;
        return view ('layouts.hellosign', compact ('sign_url'));

//        return View::make('agreement')
//            ->with('sign_url', $sign_url);
    }
}

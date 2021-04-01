<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\DB;

class UserController extends Controller
{
    public function RegisterUser(Request $request)
    {

        /////////////////////////////GET USER COUNTRY////////////////////////////////////

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://us-street.api.smartystreets.com/street-address?auth-id=20ed317d-7db6-2ac8-45bd-3471b29cef96&auth-token=ekpG61yhhcHcjc2DeZeK',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '[{"street":"' . $request['street'] . '","street2":"","city":"' . $request['city'] . '","state":"' . $request['state'] . '","zipcode":"' . $request['zipcode'] . '"}]',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json'
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        // print_r('street":"' . $request['street'] . '","street2":"","city":"' . $request['city'] . '","state":"' . $request['state'] . '","zipcode":"' . $request['zipcode'] . '"}');
        // print_r($response);
        // print_r(json_decode($response, true));
        // exit();
        // print_r(json_decode($response, true));
        // exit();
        if (json_decode($response, true)) {
            $countryName = (!empty($response)) ? json_decode($response, true)[0]['metadata']['county_name'] : '';
        } else {
            $countryName = '';
        }

        /////////////////////////////////////////////////////////////////////////////////
        $emaill = User::where('email', '=', $request['email'])->select('email')->first();
        // print_r($emaill['email']);
        // exit();
        if (empty($emaill['email'])) {
            // print_r($request['email']);
            // exit();
            $user = new User;
            $user->fill($request->input());
            $user->name = str_replace(' ', '', strtolower($request->input('name')));
            $user->country = (isset($countryName) ? $countryName : '');
            $user->save();

            Session::flash('success', 'User Successfully Added');
        } else {
            Session::flash('error', 'User Already Exist');
        }

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(){
        return view('advertiser.login');
    }

    function verifyLogin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$validation->fails()) {
            $advertiser = Advertiser::where(['email' => $request->email])->first();
          
            if ($advertiser && Hash::check($request->password, $advertiser->password)){
                if ($advertiser->status != 1) {
                    $this->response['error'] = "Your account is inactive. Please contact support.";
                } else {
                    session()->put('advertiser', $advertiser);

                    $this->response['status'] = 1;
                    $this->response['msg'] = "Login successful...";
                    $this->response['redirect_url'] = url('advertiser/dashboard');
                }
            } else {
                $this->response['error'] = "Invalid credentials!";
            }
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function logout()
    {
        session()->forget('advertiser');
        return redirect('advertiser/login');
    }
}


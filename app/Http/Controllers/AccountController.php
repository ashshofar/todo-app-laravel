<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Models\User;

use Hash;
use Validator;

class AccountController extends Controller
{
    public function register(Request $request)
    {
        $response   = [];
        $validator  = Validator::make($request->all(), UserRequest::rules());

        if ($validator->fails()) {
            $message    = $validator->errors();
            $status     = 422;
        } else {
            $name       = $request->name;
            $username   = $request->username;
            $password   = Hash::make($request->password);

            $user = new User();
            $user->name     = $name;
            $user->username = $username;
            $user->password = $password;
            $user->save();

            return $this->getResponse(200, '', 'Pendaftaran berhasil');
        }

        return $this->getResponse($status, $response, $message);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use JWTAuth;
use Log;

use Carbon\Carbon;

class JwtAuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $check = User::where('username', $credentials['username'])->first();
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->getResponse(401, '', 'Username atau password salah');
            }
        } catch (JWTException $e) {
            return $this->getResponse(500, '', 'Could not create token');
        }

        return $this->getResponse(200, compact('token'), 'Login berhasil');
    }
}

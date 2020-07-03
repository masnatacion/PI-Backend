<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Entities\User;

class LoginController extends ApiController
{
    public function login(Request $request, User $user)
    {
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->bad_request($validator->errors());
        }

        $user = $user->whereUsername($request->get('username'))->firstOrFail();

        if(!$user->isAdmin() || !$user->isActive())
            return $this->unauthorized();

        if (!$token = auth()->attempt($validator->validated())) {
            return $this->unauthorized();
        }

        return $this->ok([
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->ok('Successfully logged out');
    }
}

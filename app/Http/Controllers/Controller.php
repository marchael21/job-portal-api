<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	protected function respondWithToken($token)
    {
        return response()->json([
        	'id' => Auth::user()->id,
        	'email' => Auth::user()->email,
        	'name' => Auth::user()->name,
        	'role' => Auth::user()->role->name,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create(){
        return view('auth.signIn');
    }

    public function registration(Request $request) {
        $request->validate([
            'username'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        $response = [
            'username' => $request->input('username'),
            'email' => $request->input('email')
        ];

        return response()->json($response, 200);
    }
}

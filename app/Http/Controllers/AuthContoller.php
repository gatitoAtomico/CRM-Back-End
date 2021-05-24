<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthContoller extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json([
                'message'=> 'Invalid Credentials'
            ],Response::HTTP_UNAUTHORIZED);

//            return response("Invalid Credentials", Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
//        create a cookie to pass it in the headers
        $cookie = cookie('jwt', $token, 60 * 24);
        return response([
            'jwt' => $token
        ])->withCookie($cookie);

    }

    public function logout()
    {
//        destroy the previous cookie
        $cookie = Cookie::forget('jwt');
        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return response()->json([
            'authUserId'=> $request->user()->id
        ]);
    }

}

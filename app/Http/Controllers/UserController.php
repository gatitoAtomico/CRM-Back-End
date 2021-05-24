<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $avatar_path =  $request->user()->avatar;
        $userName = $request->user()->first_name;
        $lastName = $request->user()->last_name;
        $email = $request->user()->email;
        $userRole = Roles::where('user_id','=', $request->user()->id)->pluck('role')->first();

        return response()->json([
            'name' => $request->user()->first_name,
            'lastName' => $lastName = $request->user()->last_name,
            'email' => $request->user()->email,
            'role' =>  $userRole,
            'avatar_url'=>  url('storage/user-avatar/'.$avatar_path)
        ]);
    }


    public function update(Request $request)
    {
        // validate request data
        $data = $request->validate([
            'avatar'   => ['image', 'dimensions:max_width=1000,max_height=1000'],
            'name'     => ['string', 'required', ],
            'email'    => ['required', 'email'],
            'lastName' => ['required', 'string'],
        ]);

        // check if image has been received from request
        if($request->file('avatar')){
            // check if user has an existing avatar
            if($request->user()->avatar != "default.jpg"){

                // delete existing image file
                Storage::disk('user_avatars')->delete($request->user()->avatar);
            }

            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $shuffled = str_shuffle($str);
            // processing the uploaded image
            $avatar_name =   $shuffled.'.'.$request->file('avatar')->getClientOriginalExtension();
            $avatar_path = $request->file('avatar')->storeAs('',$avatar_name, 'user_avatars');

            // Update user's avatar column on 'users' table
            $profile = User::find($request->user()->id);
            $profile->avatar = $avatar_path;
            // update User Profile
            $profile->first_name = $request->name;
            $profile->last_name = $request->lastName;
            $profile->email = $request->email;

            if($profile->save()){
                return response()->json([
                    'status'    =>  'success',
                    'message'   =>  'Profile Updated!',
                    'avatar_url'=>  url('storage/user-avatar/'.$avatar_path),
                    'name' => $request->name,
                    'email' => $request->email,
                    'lastName' => $request->lastName,

                ]);
            }else{
                return response()->json([
                    'status'    => 'failure',
                    'message'   => 'failed to update profile!',
                    'avatar_url'=> NULL,
                    'name' => NULL,
                    'email' => NULL,
                    'lastName' => NULL,
                ]);
            }

        }
        return response()->json([
            'status'    => 'failure',
            'message'   => 'No image file uploaded!',
            'avatar_url'=>  url('storage/user-avatar/'.$request->user()->avatar),
            'name' => $request->user()->first_name,
            'email' => $request->user()->email,
            'lastName' => $request->user()->last_name,
        ]);


    }

}

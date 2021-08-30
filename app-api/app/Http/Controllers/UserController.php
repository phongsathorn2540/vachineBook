<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $user->name = is_null($request->name) ? $user->name : $request->name;
        $user->lastname = is_null($request->lastname) ? $user->lastname : $request->lastname;
        $user->birthday = is_null($request->birthday) ? $user->birthday : $request->birthday;
        $user->save();
        return response()->json(['status' => 'Success', 'message' => 'Update success']);

    }
}
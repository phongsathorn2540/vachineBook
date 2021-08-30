<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function createOTP(Request $request)
    {
        try {
            $this->validate($request, [
                'phone' => 'required|unique:users',
            ]);

            $user = new User;
            $user->phone = $request->phone;
            $user->save();

            $otp = new Otp;
            $otp->user_id = $user->id;
            $otp->ref_code = Str::random(6);
            $otp->otp_num = rand(1000, 9999);
            $otp->save();
            return response()->json(['status' => 'Success', 'message' => $otp]);
        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }

    public function loginbyOTP(Request $request)
    {
        $user = user::where('phone', $request->phone)->first();
        $otp = new Otp;
        $otp->user_id = $user->id;
        $otp->ref_code = Str::random(6);
        $otp->otp_num = rand(1000, 9999);
        $otp->save();
        return response()->json(['status' => 'Success', 'message' => $otp]);

    }

    public function confirmOTP(Request $request)
    {
        try {
            $this->validate($request, [
                'phone' => 'required',
                'ref_code' => 'required',
                'otp_num' => 'required',
            ]);
            $user = User::where('phone', $request->phone)->first();
            if (!is_null($user->id)) {
                $otp = Otp::where('user_id', $user->id)->where('otp_verify', 'available')->first();
                if (!is_null($otp)) {
                    if ($otp->ref_code === $request->ref_code and $otp->otp_num === $request->otp_num) {
                        $otp->otp_verify = 'used';
                        $otp->save();
                        $user->otp_confirmed = 1;
                        $user->save();
                        return response()->json(['status' => 'Success', 'message' => 'verify otp success.']);
                    }
                }
                return response()->json(['status' => 'Fail', 'message' => 'otp not found.']);
            }
            return response()->json(['status' => 'Fail', 'message' => 'phone not found.']);
        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }
}
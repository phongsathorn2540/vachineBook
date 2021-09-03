<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            $this->validate($request, [
                'phone' => 'required',
                'booking_date' => 'required',
            ]);
            $user = User::where('phone', $request->phone)->first();
            $quoteBooking = Booking::where('booking_date', $request->booking_date)->count();
            if ($quoteBooking < 3000) {
                $oldBooking = Booking::where('user_id', $user->id)->where('booking_status', 'booking')->get();
                foreach ($oldBooking as $value) {
                    $bookingID = Booking::find($value->id);
                    $bookingID->booking_status = 'fail';
                    $bookingID->save();
                }
                $booking = new Booking;
                $booking->user_id = $request->user_id;
                $booking->booking_date = $request->booking_date;
                $booking->save();
            }
            return response()->json(['status' => 'Success', 'message' => 'Booking success']);
        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }

    public function checkEmail(Request $request)
    {
        try {
            $data = User::where('email', $request->email)->first();
            if (is_null($data)) {
                return response()->json(['status' => 'Success', 'message' => 'email available']);
            }
            return response()->json(['status' => 'Fail', 'message' => 'email not available']);
        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }

    public function checkPhone(Request $request)
    {
        try {
            $data = User::where('phone', $request->phone)->first();
            if (is_null($data)) {
                return response()->json(['status' => 'Success', 'message' => 'phone available']);
            }
            return response()->json(['status' => 'Fail', 'message' => 'phone not available']);

        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }

    public function checkIdCard(Request $request)
    {
        try {
            $data = User::where('id_card', $request->id_card)->first();
            if (is_null($data)) {
                return response()->json(['status' => 'Success', 'message' => 'id card available']);
            }
            return response()->json(['status' => 'Fail', 'message' => 'id card not available']);

        } catch (\Throwable$th) {
            return response()->json(['status' => 'Fail', 'message' => $th->getMessage()]);
        }
    }

    public function updateIdCard(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            $user->id_card = $request->id_card;
            $user->save();
            return response()->json(['status' => 'Success', 'message' => 'Update Success.']);
        } catch (\Throwable$th) {
            //throw $th;
        }
    }
    public function updateEmail(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            $user->email = $request->email;
            $user->save();
            return response()->json(['status' => 'Success', 'message' => 'Update Success.']);
        } catch (\Throwable$th) {
            //throw $th;
        }
    }

    public function bookingDetail(int $id)
    {
        try {
            $data = Booking::find($id);
            $data->load('user');
            return response()->json(['status' => 'Success', 'message' => $data]);
        } catch (\Throwable$th) {
            //throw $th;
        }
    }

    public function getBookingbyUser(String $phone)
    {
        try {
            $user = User::where('phone', $phone)->first();
            $booking = Booking::where('user_id', $user->id)->get();
            $data['profile'] = $user;
            $data['booking'] = $booking;
            return response()->json(['status' => 'success', 'message' => $data]);

        } catch (\Throwable$th) {
            //throw $th;
        }
    }

    public function stats()
    {
        try {
            $data = [];
            $data['totalBooking'] = Booking::count();
            $data['cancelBooking'] = Booking::where('booking_status', 'fail')->count();
            $data['successBooking'] = Booking::where('booking_status', 'success')->count();
            return response()->json(['status' => 'success', 'message' => $data]);
        } catch (\Throwable$th) {
            //throw $th;
        }
    }
}
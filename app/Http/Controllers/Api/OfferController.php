<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Address;
use App\Models\Work;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Helpers\GeoCoordinate;

class OfferController extends Controller
{
    public function index()
    {
    # code...
    }

    public function getJob($id)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->first();
        $work = Work::find($id);

        if (!$work) {
            return ResponseFormatter::error(null, 'Work not found', 404);
        }

        $userLatitude = $address->latitude;
        $userLongitude = $address->longitude;

        $userLocation = new GeoCoordinate($userLatitude, $userLongitude);

        $workLatitude = $work->latitude;
        $workLongitude = $work->longitude;

        $workLocation = new GeoCoordinate($workLatitude, $workLongitude);

        $distance = $userLocation->distanceTo($workLocation);

        if ($distance >= 1000) {
            $distance = number_format($distance / 1000, 2) . ' km';
        } else {
            $distance = number_format($distance, 2) . ' m';
        }

        $work->distance_to_user = $distance;

        return ResponseFormatter::success(['work' => $work, 'address' => $address], 'Work displayed successfully!');
    }

    public function placeAnOffer(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'tariff' => 'required',
            'experience' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = Offer::create([
            'user_id' => $user->id,
            'work_id' => $request->work_id,
            'address_id' => $request->address_id,
            'tariff' => $request->tariff,
            'experience' => $request->experience,
        ]);

        return ResponseFormatter::success($data, 'Data has been successfully saved');
    }
}

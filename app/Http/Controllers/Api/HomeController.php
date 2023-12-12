<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseFormatter;
use App\Helpers\GeoCoordinate;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->first();

        if (!$address) {
            return ResponseFormatter::error(null, 'User address not found', 404);
        }

        $userLatitude = $address->latitude;
        $userLongitude = $address->longitude;

        $userLocation = new GeoCoordinate($userLatitude, $userLongitude);

        $closestWork = Work::select(DB::raw('*,
            ( 6371000 * acos( cos( radians(' . $userLatitude . ') )
            * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(' . $userLongitude . ') )
            + sin( radians(' . $userLatitude . ') )
            * sin( radians( latitude ) ) ) ) AS distance'))
            ->orderBy('distance')
            ->limit(4)
            ->get();

        foreach ($closestWork as $closest) {
            $closestWorkLatitude = $closest->latitude;
            $closestWorkLongitude = $closest->longitude;

            $closestWorkLocation = new GeoCoordinate($closestWorkLatitude, $closestWorkLongitude);

            $distance = $userLocation->distanceTo($closestWorkLocation);

            $closest->distance_to_user = ($distance >= 1000) ? number_format($distance / 1000, 2) . ' km' : number_format($distance, 2) . ' m';
        }

        $allWorks = Work::select(DB::raw('*,
            ( 6371000 * acos( cos( radians(' . $userLatitude . ') )
            * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(' . $userLongitude . ') )
            + sin( radians(' . $userLatitude . ') )
            * sin( radians( latitude ) ) ) ) AS distance'))
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        foreach ($allWorks as $work) {
            $workLatitude = $work->latitude;
            $workLongitude = $work->longitude;

            $workLocation = new GeoCoordinate($workLatitude, $workLongitude);

            $distance = $userLocation->distanceTo($workLocation);

            $closest->distance_to_user = ($distance >= 1000) ? number_format($distance / 1000, 2) . ' km' : number_format($distance, 2) . ' m';
        }

        return ResponseFormatter::success([
            'closest_work' => $closestWork,
            'all_works_with_distance' => $allWorks
        ], 'Data displayed successfully!');
    }

    public function recruiter()
    {
        $user = Auth::user();
        $works = Work::where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(12)->get();

        return ResponseFormatter::success([
            'works' => $works
        ], 'Data displayed successfully!');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Address;
use App\Models\Work;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Helpers\GeoCoordinate;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
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

    public function offersUser()
    {
        $user = Auth::user();

        $pending = Offer::where('offers.user_id', $user->id)
                        ->where('offers.status', 'Pending')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->get();
        $accepted = Offer::where('offers.user_id', $user->id)
                        ->where('offers.status', 'Diterima')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->get();
        $finished = Offer::where('offers.user_id', $user->id)
                        ->where('offers.status', 'Selesai')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->get();
        $rejected = Offer::where('offers.user_id', $user->id)
                        ->where('offers.status', 'Ditolak')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->get();

        return ResponseFormatter::success([
            'pending' => $pending,
            'accepted' => $accepted,
            'finished' => $finished,
            'rejected' => $rejected
        ], 'Data displayed successfully!');
    }

    public function offersRecruiter()
    {
        $user = Auth::user();

        $result = [];

        $pending = Offer::where('offers.status', 'Pending')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->where('works.user_id', $user->id)
                        ->get();
        $accepted = Offer::where('offers.status', 'Diterima')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->where('works.user_id', $user->id)
                        ->get();
        $finished = Offer::where('offers.status', 'Selesai')
                        ->join('users', 'offers.user_id', '=', 'users.id')
                        ->join('works', 'offers.work_id', '=', 'works.id')
                        ->select('users.fullname as user_fullname', 'users.photo as user_photo', 'works.title as work_title', 'works.image as work_image', 'offers.*')
                        ->where('works.user_id', $user->id)
                        ->get();

        $allOffers = $pending->merge($accepted)->merge($finished);

        $allUserIds = $allOffers->pluck('user_id')->unique()->toArray();
        $allWorkIds = $allOffers->pluck('work_id')->unique()->toArray();
        $allAddressIds = $allOffers->pluck('address_id')->unique()->toArray();

        $ratings = Rating::whereIn('user_id', $allUserIds)
                        ->whereIn('work_id', $allWorkIds)
                        ->select('user_id', 'work_id', 'star', DB::raw('COUNT(*) as count'))
                        ->groupBy('user_id', 'work_id', 'star')
                        ->orderByDesc('count')
                        ->get()
                        ->unique('user_id');

        $addresses = Address::whereIn('id', $allAddressIds)->get();

        foreach ($allWorkIds as $workId) {
            $distance = Work::find($workId);

            if (!$distance) {
                return ResponseFormatter::error(null, 'Work not found', 404);
            }

            $distanceLatitude = $distance->latitude;
            $distanceLongitude = $distance->longitude;

            $distanceLocation = new GeoCoordinate($distanceLatitude, $distanceLongitude);

            foreach ($addresses as $userAddress) {
                $userLatitude = $userAddress->latitude;
                $userLongitude = $userAddress->longitude;

                $userLocation = new GeoCoordinate($userLatitude, $userLongitude);

                $distanceValue = $userLocation->distanceTo($distanceLocation);

                if ($distanceValue >= 1000) {
                    $distanceFormatted = number_format($distanceValue / 1000, 2) . ' km';
                } else {
                    $distanceFormatted = number_format($distanceValue, 2) . ' m';
                }

                $distance->distance_to_user = $distanceFormatted;
            }
        }

        $pendingWithRatingsAndDistance = $this->addRatingsAndDistanceToOffers($pending, $ratings, $distance);
        $acceptedWithRatingsAndDistance = $this->addRatingsAndDistanceToOffers($accepted, $ratings, $distance);
        $finishedWithRatingsAndDistance = $this->addRatingsAndDistanceToOffers($finished, $ratings, $distance);

        $result = [
            'pending' => $pendingWithRatingsAndDistance,
            'accepted' => $acceptedWithRatingsAndDistance,
            'finished' => $finishedWithRatingsAndDistance
        ];

        return ResponseFormatter::success($result, 'Data displayed successfully!');
    }

    private function addRatingsAndDistanceToOffers($offers, $ratings, $distance)
    {
        return $offers->map(function ($offer) use ($ratings, $distance) {
            $userRatings = $ratings->where('user_id', $offer->user_id)->where('work_id', $offer->work_id)->first();
            return array_merge($offer->toArray(), ['ratings' => $userRatings, 'distance' => $distance->distance_to_user]);
        });
    }

    public function finished(Request $request,$id)
    {
        $offer = Offer::find($id);

        $offer->update([
            'status' => 'Selesai'
        ]);

        return ResponseFormatter::success($offer, 'Data has been successfully updated');
    }
}

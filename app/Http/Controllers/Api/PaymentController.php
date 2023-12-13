<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Offer;
use App\Models\Address;
use App\Models\Work;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Helpers\GeoCoordinate;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
    public function index($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return ResponseFormatter::error(null, 'Offer not found', 404);
        }

        $ratings = Rating::where('user_id', $offer->user_id)
                            ->where('work_id', $offer->work_id)
                            ->select('user_id', 'star', DB::raw('COUNT(*) as count'))
                            ->groupBy('user_id', 'star')
                            ->orderByDesc('count')
                            ->get()
                            ->unique('user_id');

        $address = Address::find($offer->address_id);

        $result = $this->addRatingsAndAddressToOffers($offer, $ratings, $address);

        return ResponseFormatter::success($result, 'Data displayed successfully!');
    }

    private function addRatingsAndAddressToOffers($offer, $ratings, $address)
    {
        $userRatings = $ratings->where('user_id', $offer->user_id)->first();
        return array_merge($offer->toArray(), ['ratings' => $userRatings, 'address' => $address]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'payment_method' => 'required',
            'bid_price' => 'required',
            'admin_fees' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $payment = Payment::create($request->all());

        $offer = Offer::find($request->offer_id);

        $offer->update([
            'status' => 'Diterima'
        ]);

        return ResponseFormatter::success($payment, 'Data has been successfully saved');
    }
}

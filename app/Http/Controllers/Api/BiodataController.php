<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class BiodataController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nik' => 'required|min:16|max:16',
            'fullname' => 'required',
            'birthday' => 'required',
            'telephone' => 'required|max:15',
            'province' => 'required',
            'city' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user->nik = $request->nik;
        $user->fullname = $request->fullname;
        $user->birthday = $request->birthday;
        $user->save();

        $address = Address::create([
            'user_id' => $user->id,
            'fullname' => $request->fullname,
            'telephone' => $request->telephone,
            'province' => $request->province,
            'city' => $request->city,
            'subdistrict' => $request->subdistrict,
            'village' => $request->village,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return ResponseFormatter::success([
            'user' => $user,
            'address' => $address
        ], 'Data has been successfully saved');
    }
}

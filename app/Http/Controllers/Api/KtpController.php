<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KtpVerified;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Storage;

class KtpController extends Controller
{
    public function index()
    {
        $data = KtpVerified::all();

        return ResponseFormatter::success($data, 'Data displayed successfully!');
    }

    public function verification(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:8048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $image = $request->file('ktp');
        $fileName = uniqid('image_').'.'.$image->getClientOriginalExtension();

        Storage::disk('gcs')->put('ktp/' . $fileName, file_get_contents($image->getRealPath()));

        $imageUrl = Storage::disk('gcs')->url('ktp/' . $fileName);

        $data = KtpVerified::create([
            'user_id' => $user->id,
            'ktp' => $imageUrl
        ]);

        return ResponseFormatter::success($data, 'KTP has been successfully verified');
    }
}

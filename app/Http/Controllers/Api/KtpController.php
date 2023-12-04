<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KtpVerified;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use Google\Cloud\Storage\StorageClient;

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

        if (!$request->hasFile('ktp')) {
            $image = $request->file('ktp');
            $storage = new StorageClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE')
            ]);
            $bucketName = env('GOOGLE_CLOUD_BUCKET');
            $bucket = $storage->bucket($bucketName);

            $fileData = file_get_contents($image->getRealPath());
            $fileName = uniqid('image_').'.'.$image->getClientOriginalExtension();
            $object = $bucket->upload($fileData, [
                'name' => $fileName
            ]);

            $imageUrl = $object->signedUrl(new \DateTime('tomorrow'));

            $data = KtpVerified::create([
                'user_id' => $user->id,
                'ktp' => $imageUrl
            ]);

            return ResponseFormatter::success($data, 'KTP has been successfully verified');
        }

        return ResponseFormatter::error(null, 'KTP file not found', 404);
    }
}

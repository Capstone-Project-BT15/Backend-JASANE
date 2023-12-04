<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use Google\Cloud\Storage\StorageClient;
use App\Helpers\GeoCoordinate;

class WorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $works = Work::all();

        $userLatitude = $user->latitude;
        $userLongitude = $user->longitude;

        $userLocation = new GeoCoordinate($userLatitude, $userLongitude);

        foreach ($works as $work) {
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
        }

        return ResponseFormatter::success($works, 'Data displayed successfully!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:8048',
            'title' => 'required',
            'category_id' => 'required',
            'telephone' => 'required',
            'min_budget' => 'required',
            'max_budget' => 'required',
            'type_of_work' => 'required',
            'start_date' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!$request->hasFile('image')) {
            $image = $request->file('image');
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

            $data = Work::create([
                'image' => $imageUrl,
                'title' => $request->title,
                'category_id' => $request->category_id,
                'telephone' => $request->telephone,
                'min_budget' => $request->min_budget,
                'max_budget' => $request->max_budget,
                'type_of_work' => $request->type_of_work,
                'start_date' => $request->start_date,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return ResponseFormatter::success($data, 'Data has been successfully saved');
        }

        return ResponseFormatter::error(null, 'Image file not found', 404);
    }

    public function show($id)
    {
        $user = Auth::user();
        $work = Work::find($id);

        if (!$work) {
            return ResponseFormatter::error(null, 'Work not found', 404);
        }

        $userLatitude = $user->latitude;
        $userLongitude = $user->longitude;

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

        return ResponseFormatter::success($work, 'Work displayed successfully!');
    }
}

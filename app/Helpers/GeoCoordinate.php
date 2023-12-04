<?php

namespace App\Helpers;

class GeoCoordinate
{
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function distanceTo($destination)
    {
        $earthRadius = 6371000; // Earth radius in meters
        $latDiff = deg2rad($destination->latitude - $this->latitude);
        $lonDiff = deg2rad($destination->longitude - $this->longitude);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($this->latitude)) * cos(deg2rad($destination->latitude)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}

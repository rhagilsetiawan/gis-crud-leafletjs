<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Place as PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;


class PlaceApiController extends Controller
{
    public function index() {
        $places = Place::all();
        // Struktur geoJSON
        $geoJSONdata = $places->map(function ($place) {
            return [
                'type' => 'Feature',
                'properties' => new PlaceResource($place),
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $place->longitude,
                        $place->latitude,

                    ],
                ],
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }



}

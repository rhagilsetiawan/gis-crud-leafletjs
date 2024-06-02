<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // struktur datatable
    public function places()
    {
        $places = Place::latest()->get();
        return datatables()->of($places)
            ->addColumn('action', 'places.button')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
}

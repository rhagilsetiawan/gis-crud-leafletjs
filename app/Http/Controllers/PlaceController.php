<?php

namespace App\Http\Controllers;

use App\Models\Place;
// use App\Http\Resources\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PlaceController extends Controller
{
    public function index(Place $place)
    {
        return view('places.index');
    }


    public function create()
    {
        return view('places.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'address'   => 'required|min:10',
            'description' => 'required|min:10',
            'longitude'  => 'required',
            'latitude'  => 'required'
        ]);

        $place = new Place;
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = $file->hashName();
            $file->move('upload/place/', $uploadFile);
            $place->image = $uploadFile;
        }

        $place->name = $request->input('name');
        $place->address = $request->input('address');
        $place->description = $request->input('description');
        $place->latitude = $request->input('latitude');
        $place->longitude = $request->input('longitude');
        $place->save();
        if ($place) {
            notify()->success('Place has been created');
            return redirect()->route('places.index');
        } else {
            notify()->error('Place not been created');
            return redirect()->route('places.create');
        }
    }


    public function show(Place $place)
    {
        return view('places.detail', [
            'place' => $place,
        ]);
    }


    public function edit(Place $place)
    {
        return view('places.edit', [
            'place' => $place,
        ]);
    }


    public function update(Request $request, Place $place)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'address'   => 'required|min:10',
            'description' => 'required|min:10',
            'longitude'  => 'required',
            'latitude'  => 'required'
        ]);

        if ($request->hasFile('image')) {
            /**
             * Hapus file image pada folder public/upload/spots
             */
            if (File::exists('upload/place/' . $place->image)) {
                File::delete('upload/place/' . $place->image);
            }

            $file = $request->file('image');
            $uploadFile = $file->hashName();
            $file->move('upload/place/', $uploadFile);
            $place->image = $uploadFile;

            $place->update([
            'image' => $request->image,
            ]);
        }

        $place->update([
            'name' => $request->name,
            'address'  => $request->address,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        notify()->info('Place has been updated');
        return redirect()->route('places.index');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        notify()->warning('Place has been deleted');
        return redirect()->route('places.index');
    }
}

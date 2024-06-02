@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <style>
        #mapid {
            min-height: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('places.index') }}" class="text-center">
                <button class="btn btn-secondary btn-sm m-2">
                    <i class='fas fa-angle-double-left me-2' style='font-size:;color:'></i>
                    Back</button>
            </a>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="container mb-2" id="mapid"></div>
                        <div class="w-100">
                            <img src="{{ $place->getImageAsset() }}" alt="{{ $place->getImageAsset() }}"
                                class="object-fit-contain">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    @include('notify::components.notify')
                    <div class="card-header">Update Place</div>
                    <div class="card-body">
                        <form action="{{ route('places.update', $place) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="form-row mb-2">
                                    <div class="col">
                                        <label for="">Place Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $place->name }}">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="image">Upload image</label>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            placeholder="{{ $place->image }}">
                                        <small><strong>**let empty if there is no image to upload</strong></small>
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row row mb-2">
                                    <div class="col-md-6">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" readonly
                                            class="form-control @error('latitude') is-invalid @enderror"
                                            value="{{ $place->latitude }}">
                                        @error('latitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" readonly
                                            class="form-control @error('longitude') is-invalid @enderror"
                                            value="{{ $place->longitude }}">
                                        @error('longitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="description">Description</label>
                                <textarea name="description" placeholder="Description here..."
                                    class="form-control @error('description') is-invalid @enderror" cols="2" rows="4">{{ $place->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" placeholder="address here..." class="form-control @error('address') is-invalid @enderror"
                                    cols="2" rows="4">{{ $place->address }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                </div>

                <div class="form-group float-right mt-4">
                    <button type="submit" class="btn btn-primary btn-block">Update Place</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <script>
        var mapCenter = [@json($place->latitude), @json($place->longitude)];
        var map = L.map('mapid').setView(mapCenter, {{ config('leafletsetup.zoom_level') }});
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);

        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Your location :" + marker.getLatLng().toString())
                .openPopup();
            return false;
        };

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude);
        });

        var updateMarkerByInputs = function() {
            return updateMarker($('#latitude').val(), $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);
    </script>
@endpush

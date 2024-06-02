@extends('layouts.app')
@section('styles') 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    @include('notify::components.notify')
                    <div class="card-header">Add New Place</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <a href="{{ route('places.create') }}" class="btn btn-primary btn-sm float-right">Add New
                            Place</a>
                        <table class="table table-hovered" id="tablePlace">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Place Name</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" id="deleteForm">
        @csrf
        @method('DELETE')
        <input type="submit" value="Hapus" style="display:none">
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            $('#tablePlace').DataTable({
                processing: true,
                serverSide: true,
                responisve: true,
                lengthChange: true,
                autoWidth: false,
                ajax: '{{ route('places.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush

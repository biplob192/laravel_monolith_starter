@extends('master')

@section('Title')
Crop Details
@endsection

@section('Style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('Content')
<div class="content">
    <div class="container-fluid">
        {{-- Server side render --}}
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong>CROP: {{ $crop->name}}</strong> <i>({{ $crop->scientific_name }})</i></h5>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; align-items: center;">
                            <p class="card-text text-justify">
                            <img src='{{ asset("storage")."/".$crop->image }}' alt="Crop Image" class="img-thumbnail" style="float: left; width: 90px; height: 90px; margin-right:15px;">
                            <strong>Description:</strong> {{ $crop->description }}</p>
                        </div>
                      {{-- <a href="{{route('crops.edit', $crop->id)}}" class="btn btn-primary">Edit Crop</a> --}}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 p-2">
                                <h5 class="card-title"><strong>REQUIREMENTS</strong></h5>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-md-5 p-2">
                                        <select class="form-control" id="varietyDropdown">
                                            <option value="">Select Variety</option>
                                            @foreach ($varieties as $variety)
                                                <option value="{{ $variety->id }}">{{ $variety->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5 p-2">
                                        <select class="form-control" id="soilTypeDropdown">
                                            <option value="">Select Soil Type</option>
                                            @foreach ($soil_types as $soil_type)
                                                <option value="{{ $soil_type->id }}">{{ $soil_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2 p-2 text-right">
                                        <button type="button" class="btn btn-primary w-100 filter-button" id="filterButton">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card-body">
                        {{-- <table id="example" class="display table table-bordered table-hover" style="width:100%"> --}}
                        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Water</th>
                                    <th>Nitrogen</th>
                                    <th>Potassium</th>
                                    <th>Phosphorus</th>
                                    {{-- <th>Edit</th> --}}
                                    {{-- <th>Delete</th> --}}
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Water</th>
                                    <th>Nitrogen</th>
                                    <th>Potassium</th>
                                    <th>Phosphorus</th>
                                    {{-- <th>Edit</th> --}}
                                    {{-- <th>Delete</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script')
@include('include.data_table_script')

<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
    var table;
    var cropID = {{ $crop->id }};
    $(document).ready(function() {
        table = new DataTable('#example', {
            ajax: 'get/data/' + cropID,
            responsive: true,
            processing: true,
            serverSide: true,
        });
    });
</script> --}}

<script>
    var table;
    var cropID = {{ $crop->id }};
    var isDataTableInitialized = false; // Flag to track DataTable initialization

    $(document).ready(function() {
        var filterButton = $("#filterButton");
        console.log(isDataTableInitialized);

        // Initialize the DataTable only if it's not already initialized
        if (!isDataTableInitialized) {
            console.log('Inside DataTable')
            table = new DataTable('#example', {
                ajax: 'get/data/' + cropID,
                responsive: true,
                processing: true,
                serverSide: true,
            });
            isDataTableInitialized = true; // Set the flag to true to indicate initialization
        }

        // Add a click event handler to the "Filter" button
        filterButton.click(function () {
            event.preventDefault()
            console.log('Filter clicked!');
            console.log(isDataTableInitialized);

            // Get the selected values from the dropdowns
            var selectedVariety = $("#varietyDropdown").val();
            var selectedSoilType = $("#soilTypeDropdown").val();

            // Perform an AJAX request to your Laravel endpoint
            $.ajax({
                url: '/filter_crop_requirements', // Replace with your actual endpoint URL
                type: 'GET', // Use 'GET' or 'POST' as appropriate
                data: {
                    variety_id: selectedVariety,
                    soil_type_id: selectedSoilType,
                    crop_id: cropID,
                },
                dataType: 'json',
                success: function (data) {
                    // Update the data-table with the filtered data
                    updateDataTable(data);
                },
                error: function (error) {
                    // Handle errors, if any
                    console.error(error);
                }
            });
        });

        function updateDataTable(data) {
            // Clear the existing DataTable data
            table.clear().draw();

            // Add the new data to the DataTable
            if (data.data.length > 0) {
                table.rows.add(data.data).draw();
            }
        }
    });
</script>
@endsection

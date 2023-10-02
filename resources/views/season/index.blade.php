@extends('master')

@section('Title')
Crop Category
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
                        <h5 class="card-title"><strong>SEASONS (server side render)</strong></h5>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('seasons.export')}}">
                                    <p style="margin: 0; padding: 0">
                                        Export Seasons
                                    </p>
                                </a>
                            </button>
                        </div>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('seasons.create')}}">
                                    <p style="margin: 0; padding: 0">
                                        Add New
                                    </p>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <table id="example" class="display table table-bordered table-hover" style="width:100%"> --}}
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
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

{{-- Bootstrap switch --}}
<script src="{{asset('plugins')}}/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function myFunction(event) {
        let empID = event.target.value;
        // console.log(empID)
    }


    var table;
    $(document).ready(function() {
        table = new DataTable('#example', {
            ajax: 'get/data',
            responsive: true,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    targets: 0,
                    visible: false,
                    orderable: true,
                },
                {
                    targets: 2,
                    width: '20%',
                },
                {
                    targets: 3,
                    width: '20%',
                },
                {
                    targets: -2, // Edit button
                    render: function (data, type, row) {
                        return '<a href="{{route('seasons.edit', '')}}/' + row[0] + '" class="btn btn-primary edit-button" data-id="' + row[0] + '">Edit</a>';
                    },
                    orderable: false,
                },
                {
                    targets: -1, // Delete button
                    render: function (data, type, row) {
                        return '<a href="#" class="btn btn-danger delete-button" data-id="' + row[0] + '">Delete</a>';
                    },
                    orderable: false,
                },
            ],
        });
    });


    $('#example').on('click', '.delete-button', function () {
        var itemID = $(this).data('id');
        var $rowToDelete = $(this).closest('tr');

        Swal.fire({
            title: 'Confirm Deletion',
            text: 'Are you sure you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('seasons.destroy', '') }}/" + itemID,
                    type: 'DELETE',
                    success: function (response) {
                        table.row($rowToDelete).remove().draw(false);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    },
                });
            } else {
            }
        });
    });
</script>

@endsection

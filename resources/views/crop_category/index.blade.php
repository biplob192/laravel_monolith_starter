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
                        <h5 class="card-title"><strong>CATEGORIES (server side render)</strong></h5>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('categories.export')}}">
                                    <p style="margin: 0; padding: 0">
                                        Export Categories
                                    </p>
                                </a>
                            </button>
                        </div>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('categories.create')}}">
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
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Icon</th>
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
                // {
                //     targets: 0, // S/N column
                //     render: function (data, type, row, meta) {
                //     // Render the row number (meta.row is 0-based)
                //     return meta.row + 1;
                //     },
                //     orderable: false, // The S/N column is not orderable
                // },
                // {
                //     targets: 1,
                //     render: function (data, type, row) {
                //         // return '<a href="/show/' + row[0] + '">' + data + '</a>';
                //         return '<a href="{{route('categories.show', '')}}/' + row[0] + '">' + data + '</a>';
                //     },
                //     orderable: true,
                // },
                {
                    targets: 1, // Icon column
                    render: function (data, type, row) {
                        var categoryId = row[0];
                        var iconPath = row[1];
                        if (iconPath) {
                            var iconUrl = '{{ asset("storage/") }}/' + iconPath;
                            return '<img src="' + iconUrl + '" alt="Icon" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">';

                            // var iconUrl = '{{ asset("storage/") }}/' + iconPath;
                            // var showUrl = '{{ route("categories.show", ":id") }}'.replace(':id', categoryId);
                            // return '<a href="' + showUrl + '"><img src="' + iconUrl + '" alt="Icon" class="img-thumbnail" style="max-width: 50px; max-height: 50px; border-radius: 50%;"></a>';
                        } else {
                            return 'No icon';
                        }
                    },
                    orderable: false, // The Icon column is not orderable
                },
                {
                    targets: 3,
                    width: '15%',
                },
                {
                    targets: 4,
                    width: '15%',
                },
                {
                    targets: -2, // Edit button
                    render: function (data, type, row) {
                        return '<a href="{{route('categories.edit', '')}}/' + row[0] + '" class="btn btn-primary edit-button" data-id="' + row[0] + '">Edit</a>';
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
                    url: "{{ route('categories.destroy', '') }}/" + itemID,
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

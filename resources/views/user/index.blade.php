@extends('master')

@section('Title')
Users
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
                        <h5 class="card-title"><strong>USERS (server side render)</strong></h5>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('users.export')}}">
                                    <p style="margin: 0; padding: 0">
                                        Export Users
                                    </p>
                                </a>
                            </button>
                        </div>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">Sample</button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <table id="example" class="display table table-bordered table-hover" style="width:100%"> --}}
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>ID</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>ID</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Client side render --}}
        {{-- <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong>USERS (client side render)</strong></h5>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">
                                <a href="{{route('users.create')}}">
                                    <p style="margin: 0; padding: 0">
                                        New User
                                    </p>
                                </a>
                            </button>
                        </div>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">Sample</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="employee">
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone ? $user->phone : 'Phone not found!'}}</td>
                                    <td>
                                        <input type="checkbox" name="status" {{$user->status ? 'checked' :
                                        ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success"
                                        class="change_status" onchange="myFunction(event)" value="{{$user->id}}">
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
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
    // $(function () {
    //     $("#example2").DataTable({
    //         "drawCallback": function(){
    //             $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
    //                 $("input[data-bootstrap-switch]").each(function(){
    //                     $(this).bootstrapSwitch('state', $(this).prop('checked'));
    //             })
    //             });
    //         },
    //         "responsive": true,
    //         "lengthChange": true,
    //         "autoWidth": false,
    //         "buttons": ["copy", "csv", "excel", "pdf", "print"]
    //     }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


    //     $("input[data-bootstrap-switch]").each(function(){
    //         $(this).bootstrapSwitch('state', $(this).prop('checked'));
    //     });
    // });


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
                    render: function (data, type, row) {
                        return '<a href="/show/' + row[3] + '">' + data + '</a>';
                    },
                    orderable: true,
                },
                {
                    targets: -2, // Edit button
                    render: function (data, type, row) {
                        return '<a href="#" class="btn btn-primary edit-button" data-id="' + row[3] + '">Edit</a>';
                    },
                    orderable: false,
                },
                {
                    targets: -1, // Delete button
                    render: function (data, type, row) {
                        return '<a href="#" class="btn btn-danger delete-button" data-id="' + row[3] + '">Delete</a>';
                    },
                    orderable: false,
                },
            ],
        });
    });


    $('#example').on('click', '.delete-button', function () {
        var userId = $(this).data('id');
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
                    url: 'destroy/' + userId,
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
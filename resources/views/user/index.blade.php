@extends('master')

@section('Title')
Users
@endsection

@section('Style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-bs4/css/dataTables.bootstrap4.min.css">

{{--
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('plugins')}}/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
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
                        <table id="example" class="display table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Client side render --}}
        <div class="row">
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
        </div>
    </div>
</div>
@endsection

@section('Script')
@include('include.data_table_script')

{{-- Bootstrap switch --}}
<script src="{{asset('plugins')}}/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script>
    $(function () {
    $("#example2").DataTable({
        "drawCallback": function(){
            $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
            });
        },
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  });


  function myFunction(event) {
    let empID = event.target.value;
    // console.log(empID)
  }


    $(document).ready(function() {
        new DataTable('#example', {
            ajax: 'get/data',
            processing: true,
            serverSide: true,
        });
    });
</script>
@endsection
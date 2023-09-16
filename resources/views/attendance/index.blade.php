@extends('master')

@section('Title')
Attendance
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
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong>ATTENDANCES</strong></h5>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">Default</button>
                        </div>
                        <div class="float-sm-right ml-1">
                            <button type="button" class="btn btn-block btn-default">Default</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="employee">
                                @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{$attendance->id}}</td>
                                    <td>{{$attendance->user->name}}</td>
                                    <td>{{$attendance->check_in}}</td>
                                    <td>{{$attendance->check_out?$attendance->check_out:'--'}}</td>
                                    <td>{{$attendance->status}}</td>
                                    <td>
                                        <div style="display: flex">
                                            <div>
                                                <a href="{{route('attendance.destroy', [$attendance->id])}}" onclick="confirmDelete(event);" data-method="delete" style="margin-right: 15px"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </div>
                                            {{-- <a href="{{route('attendance.edit', [$attendance->id])}}" data-method="get" class="edit_attendance"><i class="fas fa-edit"></i></a> --}}
                                            <div>
                                                <form action="{{route('attendance.edit', [$attendance->id])}}" method="get"> <button type="submit"><i class="fas fa-edit"></i></button> </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins')}}/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('plugins')}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('plugins')}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('plugins')}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('plugins')}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('plugins')}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('plugins')}}/jszip/jszip.min.js"></script>
<script src="{{asset('plugins')}}/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('plugins')}}/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('plugins')}}/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('plugins')}}/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('plugins')}}/datatables-buttons/js/buttons.colVis.min.js"></script>

{{-- <script src="{{asset('plugins')}}/bootstrap-switch/js/bootstrap-switch.min.js"></script> --}}


<script src="vendor/sweetalert/sweetalert.all.js"></script>
<script>
    $(document).ready(function() {
        var user_id = $('#user_id').val();
        $('#check_out').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(function () {
        $("#example2").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    function confirmDelete(e) {
    e.preventDefault();

    const url = e.target.closest("a");
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.post({
                    type: 'delete',
                    url: url
                }).done(function(data) {
                    location.reload();
                });
            }
        });
    }

    $('.edit_attendance').click(function(e){
        e.preventDefault(); // does not go through with the link.
        var $this = $(this);
        var sure = confirm('Are you sure?');

        if (sure) {
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function(data) {
                console.log(data);
            });
        }
    });
</script>
@endsection
@extends('master')

@section('Title')
Dashboard
@endsection

@section('Style')
@endsection

@section('Content')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        @role('admin')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class=" col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><strong>ADMIN DASHBOARD CONTANT</strong></h5>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endrole

        @role('employee')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong>EMPLOYEE DASHBOARD CONTANT</strong></h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary" id="check_in">Check-In Here</a>
                        <a href="#" class="btn btn-primary" id="complete_check_in">Attendance Completed!</a>
                        <input type="hidden" value="{{ auth()->user()->id }}" id="user_id">
                        <input type="hidden" value="{{ auth()->user()->roles[0]->name }}" id="user_role">
                        <a href="#" class="btn btn-primary" id="check_out">Check-Out Here</a>
                    </div>
                </div>
            </div>
        </div>
        @endrole
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('Script')
{{-- <script src="vendor/sweetalert/sweetalert.all.js"></script> --}}
<script src="{{asset('vendor')}}/sweetalert/sweetalert.all.js"></script>
<script>
    $(document).ready(function() {
        var user_id = $('#user_id').val();
        $('#complete_check_in').hide();

        if(user_id != null){
            $('#check_out').hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                // url: "attendance/"+user_id,
                url: "{{ route('attendance.show', auth()->user()->id) }}",
                // url: "{{ route('attendance.show', '') }}/" + user_id,
                success: function(data) {
                    // console.log(data);

                    if(data.check_in){
                        $('#check_in').hide();
                        $('#check_out').show();
                    }
                    if(data.check_out){
                        $('#check_out').hide();
                        $('#check_in').hide();
                        $('#complete_check_in').show();
                    }
                }
            });
        }
    });


    $(function() {
        $('#check_in').on("click", function() {
            $('#check_in').hide();
            $('#check_out').show();
            var user_id = $('#user_id').val();

            attendance(user_id);
            // $.ajax({
            //     type: "POST",
            //     // url: "attendance",
            //     url: "{{ route('attendance.store') }}",
            //     data: {
            //         user_id: user_id,
            //     },
            //     success: function(data) {
            //         // console.log(data);

            //         swal.fire({
            //         title: 'Attendance',
            //         text: data.message,
            //         })
            //     }
            // });
        });
    });

    $(function() {
        $('#check_out').on("click", function() {
            $('#check_out').hide();
            $('#complete_check_in').show();
            var user_id = $('#user_id').val();

            attendance(user_id);
        });
    });

    function attendance(user_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('attendance.store') }}",
            data: {
                user_id: user_id,
            },
            success: function(data) {
                swal.fire({
                    title: 'Attendance',
                    text: data.message,
                })
            }
        });
    };
</script>
@endsection
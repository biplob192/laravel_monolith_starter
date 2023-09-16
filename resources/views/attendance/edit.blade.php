@extends('master')

@section('Title')
Edit Attendance
@endsection

@section('Style')
@endsection

@section('Content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong>EDIT ATTENDANCE</strong></h5>
                    </div>
                    <div class="card-body">
                        {{-- <form action="{{route('attendance.update', [$attendance->id])}}" method="PUT"> --}}
                            {{-- <form action="attendance/{{$attendance->id}}" method="port"> --}}
                                {{-- <form action="{{route('attendance.update', [$attendance->id])}}" method="put" enctype="multipart/form-data"> --}}
                                <form action="{{route('attendance.update', [$attendance->id])}}" method="POST" enctype="multipart/form-data">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    <div class="card-body row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name" value="{{$attendance->user->name}}" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="check_in">Check In</label>
                                            <input type="datetime-local" class="form-control" id="check_in" placeholder="Enter full name" name="check_in" value="{{$attendance->check_in}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="check_out">Check Out</label>
                                            <input type="datetime-local" class="form-control" id="check_out" placeholder="Enter full name" name="check_out" value="{{$attendance->check_out}}">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script')
@endsection

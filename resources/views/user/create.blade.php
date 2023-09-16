@extends('master')

@section('Title')
New User
@endsection

@section('Style')
@endsection

@section('Content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New User</h3>
                    </div>
                    <div>
                        @foreach($errors->all() as $error)
                        <div>
                            <span style="color: red; padding-left: 15px;">* {{$error}} </span>
                        </div>
                        @endforeach
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="user_role">User Type</label>
                                <select class="form-control" name="user_role">
                                    <option value="admin">Admin</option>
                                    <option value="employee" selected>Employee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter address" name="address">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="emergency_contact">Emergency Phone</label>
                                <input type="text" class="form-control" id="emergency_contact" placeholder="Enter emergency_contact" name="emergency_contact">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image">
                                        <label class="custom-file-label" for="profile_image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script')
<script>
    $(function () {
  bsCustomFileInput.init();
});
</script>
@endsection
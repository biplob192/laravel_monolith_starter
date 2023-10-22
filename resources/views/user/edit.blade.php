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
                            <h3 class="card-title">Update User Data</h3>
                        </div>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>
                                    <span style="color: red; padding-left: 15px;">* {{ $error }} </span>
                                </div>
                            @endforeach
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="user_role">User Type</label>
                                    <select class="form-control" name="user_role">
                                        <option value="admin" {{ $user['roles']->contains('name', 'admin') ? 'selected' : '' }}>Admin</option>
                                        <option value="employee" {{ $user['roles']->contains('name', 'employee') ? 'selected' : '' }}>Employee</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ $user->email }}">
                                </div>
                                {{-- <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="{{$user->address}}">
                            </div> --}}
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" value="{{ $user->phone }}">
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
                                            <input type="file" class="custom-file-input" id="profile_image" name="profile_image" onchange="previewImage(this)">
                                            <label class="custom-file-label" for="profile_image">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="image_preview">Image Preview</label>
                                    <div id="image_preview">
                                        @if ($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Image Preview" class="img-thumbnail" style="max-width: 128px; max-height: 128px;">
                                        @else
                                            <p>No image found</p>
                                        @endif
                                    </div>
                                    <div id="image_dimension_error" style="color: red;"></div>
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
    {{-- This should include if there is a input file in the form --}}
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script>
        function previewImage(input) {
            var preview = document.querySelector('#image_preview');
            var errorText = document.querySelector('#image_dimension_error');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Image Preview';
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '128px';
                    img.style.maxHeight = '128px';

                    // Check image dimensions
                    img.onload = function() {
                        // if (img.naturalWidth === 128 && img.naturalHeight === 128) {
                        if (img.naturalWidth <= 128 && img.naturalHeight <= 128) {
                            preview.appendChild(img);
                            errorText.textContent = ''; // Clear any previous error message
                        } else {
                            errorText.textContent = 'Image dimensions must be 128x128 pixels.';
                        }
                    };
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                var noImageText = document.createElement('p');
                noImageText.textContent = 'No image selected';
                preview.appendChild(noImageText);
            }
        }
    </script>
@endsection

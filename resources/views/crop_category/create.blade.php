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
                        <h3 class="card-title">Create New Crop Category</h3>
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
                    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="icon">Category Icon (128x128 pixels)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="icon" name="icon" onchange="previewIcon(this)">
                                        <label class="custom-file-label" for="icon">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="icon_preview">Icon Preview</label>
                                <div id="icon_preview">
                                    <p>No icon selected</p>
                                </div>
                                <div id="icon_dimension_error" style="color: red;"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex justify-content-end">
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
    function previewIcon(input) {
        var preview = document.querySelector('#icon_preview');
        var errorText = document.querySelector('#icon_dimension_error');
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Icon Preview';
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
            var noIconText = document.createElement('p');
            noIconText.textContent = 'No icon selected';
            preview.appendChild(noIconText);
        }
    }
</script>

@endsection
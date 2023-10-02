@extends('master')

@section('Title')
Crop
@endsection

@section('Style')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins')}}/select2/css/select2.min.css">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: gray;
    }

    /* This is for select2 single selection hight */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        padding: 0.46875rem 0.75rem;
        height: calc(2.25rem + 2px);
    }
</style>
@endsection

@section('Content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Crop</h3>
                    </div>
                    <div>
                        @foreach($errors->all() as $error)
                        <div>
                            <span style="color: red; padding-left: 15px;">* {{$error}} </span>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('crops.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="groth_stage_0">Crop Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter crop name" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="groth_stage_0">Scientific Name</label>
                                    <input type="text" class="form-control" name="scientific_name" placeholder="Enter scientific name" value="{{ old('scientific_name') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="seasons">Category</label>
                                    {{-- <select class="form-control select2" name="category_id" style="width: 100%;" required> --}}
                                        <select class="form-control" name="category_id" style="width: 100%;" required>
                                            <option selected="selected" disabled>Select category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="seasons">Season</label>
                                    <select class="select2" multiple="multiple" name="seasons[]" data-placeholder="Select multiple season" style="width: 100%;" required>
                                        @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter crop description" value="{{ old('description') }}" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Crop Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-6">
                                <div id="section-container">
                                    <!-- Initial section -->
                                    <div class="section card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Groth Stage</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="groth_stage_0">Growth Stage</label>
                                                <input type="text" class="form-control" name="sections[0][groth_stage]" placeholder="Groth stage name" value="{{ old('sections.0.groth_stage') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-danger remove" disabled data-action="remove">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <div id="section-container2">
                                    <!-- Initial section -->
                                    <div class="section card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Crop Variety</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="variety_0">Crop Variety</label>
                                                <input type="text" class="form-control" name="varieties[0][variety]" placeholder="Crop variety name" value="{{ old('varieties.0.variety') }}" required>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-danger remove2" disabled data-action="remove2">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-primary add-new">Add Growth Stage</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary add-new-variety">Add Crop Variety</button>
                                    <button type="submit" class="btn btn-primary">Save Crop</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script')
{{-- Select2 --}}
<script src="{{asset('plugins')}}/select2/js/select2.full.min.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>

{{-- This should include if there is a input file in the form --}}
<script>
    $(function () {
  bsCustomFileInput.init();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let sectionCounter = 1;
        let sectionCounter2 = 1;

        function enableRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove');
            removeButtons.forEach(button => {
                button.disabled = false;
            });
        }

        function enableRemoveButtons2() {
            const removeButtons = document.querySelectorAll('.remove2');
            removeButtons.forEach(button => {
                button.disabled = false;
            });
        }

        function disableRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove');
            if (removeButtons.length === 1) {
                removeButtons[0].disabled = true;
            }
        }

        function disableRemoveButtons2() {
            const removeButtons = document.querySelectorAll('.remove2');
            if (removeButtons.length === 1) {
                removeButtons[0].disabled = true;
            }
        }

        function createNewSection() {
            const sectionContainer = document.getElementById('section-container');

            const newSection = document.createElement('div');
            newSection.classList.add('section', 'card', 'card-secondary');

            newSection.innerHTML = `
                <div class="card-header">
                    <h3 class="card-title">Growth Stage</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="groth_stage_${sectionCounter}">Growth Stage</label>
                        <input type="text" class="form-control" name="sections[${sectionCounter}][groth_stage]" placeholder="Groth stage name" value="{{ old('sections.${sectionCounter}.groth_stage') }}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-danger remove" data-action="remove">Remove</button>
                </div>
            `;

            sectionContainer.appendChild(newSection);
            enableRemoveButtons();
            sectionCounter++;
        }

        function createNewSectionForVariety() {
            const sectionContainer = document.getElementById('section-container2');

            const newSection = document.createElement('div');
            newSection.classList.add('section', 'card', 'card-secondary');

            newSection.innerHTML = `
                <div class="card-header">
                    <h3 class="card-title">Crop Variety</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="varieties_${sectionCounter2}">Crop Variety</label>
                        <input type="text" class="form-control" name="varieties[${sectionCounter2}][variety]" placeholder="Crop variety name" value="{{ old('varieties.${sectionCounter2}.variety') }}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-danger remove2" data-action="remove2">Remove</button>
                </div>
            `;

            sectionContainer.appendChild(newSection);
            enableRemoveButtons2();
            sectionCounter2++;
        }

        function removeSection(button) {
            const section = button.closest('.section');
            section.remove();
            disableRemoveButtons();
        }

        function removeSection2(button) {
            const section = button.closest('.section');
            section.remove();
            disableRemoveButtons2();
        }

        document.querySelector('.add-new').addEventListener('click', function () {
            createNewSection();
        });

        document.querySelector('.add-new-variety').addEventListener('click', function () {
            createNewSectionForVariety();
        });

        document.addEventListener('click', function (event) {
            if (event.target && event.target.getAttribute('data-action') === 'remove') {
                removeSection(event.target);
            }

            if (event.target && event.target.getAttribute('data-action') === 'remove2') {
                removeSection2(event.target);
            }
        });
    });
</script>
@endsection
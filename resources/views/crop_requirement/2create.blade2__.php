@extends('master')

@section('Title')
Requirement
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
                        <h3 class="card-title">Create New Requirement</h3>
                    </div>
                    <div>
                        @foreach($errors->all() as $error)
                        <div>
                            <span style="color: red; padding-left: 15px;">* {{$error}} </span>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('crop_requirements.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="crop">Select Crop</label>
                                    <select class="form-control" id="crop" name="crop" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <!-- Options will be dynamically added here -->
                                        @foreach($crops as $crop)
                                        <option value="{{ $crop->id }}" {{ old('crop')==$crop->id ? 'selected' : '' }}>{{ $crop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="soil_type">Soil Type</label>
                                    <select class="form-control" id="soil_type" name="soil_type" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <!-- Options will be dynamically added here -->
                                        @foreach($crops as $crop)
                                        <option value="{{ $crop->id }}" {{ old('soil_type')==$crop->id ? 'selected' : '' }}>{{ $crop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="section-container">
                            <!-- Initial section -->
                            <div class="section card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Growth Stage</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="growth_stage_0">Select Growth Stage</label>
                                            <select class="form-control" name="sections[0][growth_stage]" id="growth_stage_0" required>
                                                <option value="" selected disabled>Select Option</option>
                                                <!-- Options will be dynamically added here -->
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="water">Water Required</label>
                                            <input type="number" step="0.01" class="form-control" name="sections[0][water]" placeholder="Water" value="{{ old('sections.0.water') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fertilizer">Fertilizer</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][nitrogen]" placeholder="Nitrogen" value="{{ old('sections.0.nitrogen') }}" required>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][potassium]" placeholder="Potassium" value="{{ old('sections.0.potassium') }}" required>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][phosphorus]" placeholder="Phosphorus" value="{{ old('sections.0.phosphorus') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-danger remove" disabled data-action="remove">Remove</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary add-new">Add New</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sectionCounter = 1;

        function enableRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove');
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

        function createNewSection() {
            const sectionContainer = document.getElementById('section-container');

            const newSection = document.createElement('div');
            newSection.classList.add('section', 'card', 'card-secondary');

            newSection.innerHTML = `
                <div class="card-header">
                    <h3 class="card-title">Growth Stage</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="growth_stage_${sectionCounter}">Select Growth Stage</label>
                            <select class="form-control" name="sections[${sectionCounter}][growth_stage]" id="growth_stage_${sectionCounter}" required>
                                <option value="" selected disabled>Select Option</option>
                                <!-- Options will be dynamically added here -->
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="water_${sectionCounter}">Water Required</label>
                            <input type="number" step="0.01" class="form-control" name="sections[${sectionCounter}][water]" placeholder="Water" value="{{ old('sections.${sectionCounter}.water') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fertilizer_${sectionCounter}">Fertilizer</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="number" step="0.01" class="form-control" name="sections[${sectionCounter}][nitrogen]" placeholder="Nitrogen" required>
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" class="form-control" name="sections[${sectionCounter}][potassium]" placeholder="Potassium" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" class="form-control" name="sections[${sectionCounter}][phosphorus]" placeholder="Phosphorus" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-danger remove" data-action="remove">Remove</button>
                </div>
            `;

            sectionContainer.appendChild(newSection);
            enableRemoveButtons();
            sectionCounter++;

            // Fetch options and populate the select element
            const selectElement = newSection.querySelector(`#growth_stage_${sectionCounter - 1}`);
            fetchOptions(selectElement);
        }

        function fetchOptions(selectElement) {
            // Make an AJAX request to your API endpoint
            fetch('{{ route("users.list") }}')
                .then(response => response.json())
                .then(data => {
                    // Populate the select element with options
                    data.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.id; // Assuming "id" is the property you want to use as the option value
                        optionElement.textContent = option.name;
                        selectElement.appendChild(optionElement);
                    });
                })
                .catch(error => console.error('Error fetching options:', error));
        }

        // Call fetchOptions for the initial section when the page loads
        const initialSelectElement = document.querySelector('#growth_stage_0');
        fetchOptions(initialSelectElement);

        // Fetch options for the "soil_type" select element when the page loads
        // const soilTypeSelectElement = document.querySelector('#soil_type');
        // fetchSoilTypeOptions(soilTypeSelectElement);

        // function fetchSoilTypeOptions(selectElement) {
        //     // Make an AJAX request to your API endpoint
        //     fetch('{{ route("users.list") }}')
        //         .then(response => response.json())
        //         .then(data => {
        //             // Populate the "soil_type" select element with options
        //             data.forEach(option => {
        //                 const optionElement = document.createElement('option');
        //                 optionElement.value = option.name; // Assuming "name" is the property you want to use as the option value
        //                 optionElement.textContent = option.name;
        //                 selectElement.appendChild(optionElement);
        //             });
        //         })
        //         .catch(error => console.error('Error fetching soil_type options:', error));
        // }

        function removeSection(button) {
            const section = button.closest('.section');
            section.remove();
            disableRemoveButtons();
        }

        document.querySelector('.add-new').addEventListener('click', function() {
            createNewSection();
        });

        document.addEventListener('click', function(event) {
            if (event.target && event.target.getAttribute('data-action') === 'remove') {
                removeSection(event.target);
            }
        });
    });
</script>
@endsection

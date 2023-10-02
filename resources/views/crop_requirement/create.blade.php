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
                                <div class="form-group col-12 col-md-4">
                                    <label for="crop">Select Crop</label>
                                    <select class="form-control" id="crop" name="crop" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <!-- Options will be dynamically added here -->
                                        @foreach($crops as $crop)
                                        <option value="{{ $crop->id }}" {{ old('crop')==$crop->id ? 'selected' : '' }}>{{ $crop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="variety">Crop Variety</label>
                                    <select class="form-control" id="variety" name="variety_id" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <!-- Options will be dynamically added here -->
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="soil_type">Soil Type</label>
                                    <select class="form-control" id="soil_type" name="soil_type" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <!-- Options will be dynamically added here -->
                                        @foreach($soilTypes as $soil_type)
                                        <option value="{{ $soil_type->id }}" {{ old('soil_type')==$soil_type->id ? 'selected' : '' }}>{{ $soil_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="section-container">
                            <!-- Initial section -->
                            <div class="section card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Growth Stage Requirement</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-md-6">
                                            <label for="groth_stage_0">Select Growth Stage</label>
                                            <select class="form-control" name="sections[0][groth_stage]" id="groth_stage_0" required>
                                                <option value="" selected disabled>Select Option</option>
                                                <!-- Options will be dynamically added here -->
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-6">
                                            <label for="water">Water Required</label>
                                            <input type="number" step="0.01" class="form-control" name="sections[0][water]" placeholder="Water" value="{{ old('sections.0.water') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fertilizer">Fertilizer</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][nitrogen]" placeholder="Nitrogen" value="{{ old('sections.0.nitrogen') }}"
                                                    required>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][potassium]" placeholder="Potassium" value="{{ old('sections.0.potassium') }}"
                                                    required>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" step="0.01" class="form-control" name="sections[0][phosphorus]" placeholder="Phosphorus" value="{{ old('sections.0.phosphorus') }}"
                                                    required>
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
    var cropID = 0;

    document.addEventListener('DOMContentLoaded', function () {
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
                    <h3 class="card-title">Growth Stage Requirement</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="groth_stage_${sectionCounter}">Select Growth Stage</label>
                            <select class="form-control" name="sections[${sectionCounter}][groth_stage]" id="groth_stage_${sectionCounter}" required>
                                <option value="" selected disabled>Select Option</option>
                                <!-- Options will be dynamically added here -->
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
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
            const selectElement = newSection.querySelector(`#groth_stage_${sectionCounter - 1}`);
            fetchOptions(selectElement, cropID);
        }

        function fetchOptions(selectElement, crop) {
            // Make an AJAX request to your API endpoint
            fetch("{{ route('groth_stages.certainCrop', '') }}/" + crop)
                .then(response => response.json())
                .then(data => {
                    // Clear all options except the first one (default)
                    while (selectElement.options.length > 1) {
                    selectElement.removeChild(selectElement.options[1]);
                    }

                    // Populate the select element with options
                    data.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.id; // Assuming "id" is the property you want to use as the option value
                        optionElement.textContent = option.name;
                        selectElement.appendChild(optionElement);
                    });

                    // Select the very first option (default one)
                    selectElement.selectedIndex = 0;
                })
                .catch(error => console.error('Error fetching options:', error));
        }

        // Call fetchOptions for the initial section when the page loads
        // const initialSelectElement = document.querySelector('#groth_stage_0');
        // fetchOptions(initialSelectElement, cropID);

        function removeSection(button) {
            const section = button.closest('.section');
            section.remove();
            disableRemoveButtons();
        }

        document.querySelector('.add-new').addEventListener('click', function () {
            createNewSection();
        });

        document.addEventListener('click', function (event) {
            if (event.target && event.target.getAttribute('data-action') === 'remove') {
                removeSection(event.target);
            }
        });

        $('#crop').on('change', function () {
            // var cropID = $(this).val();
            cropID = $(this).val();

            // Make an AJAX request
            $.ajax({
                url: "{{ route('varieties.certainCrop', '') }}/" + cropID,
                type: 'GET',
                dataType: 'json', // Ensure the response is parsed as JSON
                success: function (response) {
                    // Clear the previous options in the "Crop Variety" dropdown
                    // $('#variety').empty();

                    // Clear all options except the "Select Option" placeholder
                    $('#variety option:not(:first-child)').remove();

                    // Populate the "Crop Variety" dropdown with new options
                    $.each(response, function (index, variety) {
                        $('#variety').append($('<option>', {
                            value: variety.id,
                            text: variety.name
                        }));
                    });

                    // Select the first option in the "Crop Variety" dropdown
                    $('#variety').val($('#variety option:first-child').val());
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            // Call fetchOptions for the initial section when the page loads
            // const initialGrothStageSelectElement = document.querySelector('#groth_stage_0');
            // fetchOptions(initialGrothStageSelectElement, cropID);

            // Call fetchOptionsForAllSections to update all the growth stage dropdowns
            fetchOptionsForAllSections();
        });

        function fetchOptionsForAllSections() {
            const allGrothStageSelectElements = document.querySelectorAll('[id^="groth_stage_"]');
                allGrothStageSelectElements.forEach((selectElement, index) => {
                fetchOptions(selectElement, cropID);
            });
        }
    });
</script>
@endsection

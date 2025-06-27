@php
    $added = [];
    foreach ($university['courses'] as $course) {
        $added[] = $course['id'];
    }

    // Define the course categories and their subcategories
    $courseCategories = [
        'UG' => [
            'label' => 'Undergraduate (UG) Courses',
            'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
        ],
        'PG' => [
            'label' => 'Postgraduate (PG) Courses',
            'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
        ],
        'DIPLOMA' => [
            'label' => 'Diploma Courses',
            'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
        ],
        'CERTIFICATION' => [
            'label' => 'Certification Courses',
            'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
        ]
    ];

    // Decode JSON fields if they exist
    $university['description'] = isset($university['description']) ? json_decode($university['description'], true) : [];
    $university['facts'] = isset($university['facts']) ? json_decode($university['facts'], true) : [];
    $university['industry'] = isset($university['industry']) ? json_decode($university['industry'], true) : [];
    $university['carrier'] = isset($university['carrier']) ? json_decode($university['carrier'], true) : [];
    $university['advantages'] = isset($university['advantages']) ? json_decode($university['advantages'], true) : [];
@endphp
@extends('admin.components.layout')
@section('title', 'Edit University - CV Admin')

@section('main')
    <main class="container py-4">
        @include('admin.components.response')

        <form action="/admin/university/edit" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="univ_id" value="{{ $university['id'] }}">

            <h5 class="page_title mb-3">Edit University</h5>
            <p class="text-muted text-center mb-4">You are editing <b
                    class="text-primary">{{ $university['univ_name'] }}</b></p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="panel mt-4">
                <h6 class="section_title">University Details</h6>

                {{-- University Name & URL --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">University Name</label>
                        <input type="text" name="univ_name" class="form-control" placeholder="University Name"
                            value="{{ $university['univ_name'] }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University URL</label>
                        <input type="text" name="univ_url" class="form-control" placeholder="University URL"
                            value="{{ $university['univ_url'] }}" required>
                    </div>
                </div>

                {{-- Type & Category --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">University Type</label>
                        <select name="univ_type" class="form-select" required>
                            <option disabled selected>--- Please Select ---</option>
                            <option value="offline" {{ $university['univ_type'] === 'offline' ? 'selected' : '' }}>Offline
                            </option>
                            <option value="online" {{ $university['univ_type'] === 'online' ? 'selected' : '' }}>Online
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University Category</label>
                        <select name="univ_category" class="form-select" required>
                            <option disabled>-- Please Select --</option>
                            @php $cat = strtolower($university['univ_category'] ?? '') @endphp
                            <option value="central university" {{ $cat === 'central university' ? 'selected' : '' }}>Central
                                University</option>
                            <option value="state university" {{ $cat === 'state university' ? 'selected' : '' }}>State
                                University</option>
                            <option value="state private university" {{ $cat === 'state private university' ? 'selected' : '' }}>State Private University</option>
                            <option value="state public university" {{ $cat === 'state public university' ? 'selected' : '' }}>State Public University</option>
                            <option value="deemed university" {{ $cat === 'deemed university' ? 'selected' : '' }}>Deemed
                                University</option>
                            <option value="autonomous institute" {{ $cat === 'autonomous institute' ? 'selected' : '' }}>
                                Autonomous Institute</option>
                        </select>
                    </div>
                </div>

                {{-- Country, State, City --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <select name="country_id" id="country_id" class="form-select" required>
                            <option value="" disabled>--- Select Country ---</option>
                            @foreach (\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" {{ (old('country_id', $university['country_id']) == $country->id) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <select name="state_id" id="state_id" class="form-select" required>
                            <option value="" disabled>--- Select State ---</option>
                            @if(isset($university['country_id']))
                                @foreach (\App\Models\State::where('country_id', $university['country_id'])->get() as $state)
                                    <option value="{{ $state->id }}" {{ (old('state_id', $university['state_id']) == $state->id) ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('state_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select name="city_id" id="city_id" class="form-select" required>
                            <option value="" disabled>--- Select City ---</option>
                            @if(isset($university['state_id']))
                                @foreach (\App\Models\City::where('state_id', $university['state_id'])->get() as $city)
                                    <option value="{{ $city->id }}" {{ (old('city_id', $university['city_id']) == $city->id) ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('city_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label class="form-label">University Complete Address</label>
                    <input type="text" name="univ_address" class="form-control" placeholder="University Address"
                        value="{{ old('univ_address', $university['univ_address']) }}" required>
                    @error('univ_address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </section>

            {{-- University Other Info Section --}}
            <section class="panel mt-4">
                <h6 class="section_title">University Other Info</h6>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Established Year</label>
                        <input type="number" min="1800" max="{{ date('Y') }}" class="form-control"
                            name="univ_established_year" placeholder="e.g., 1990" required
                            value="{{ old('univ_established_year', $university['univ_established_year'] ?? '') }}">
                        @error('univ_established_year') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Approved/Recognised by</label>
                        <input type="text" class="form-control" name="univ_approved_by" placeholder="e.g., UGC, AICTE"
                            required value="{{ old('univ_approved_by', $university['univ_approved_by'] ?? '') }}">
                        @error('univ_approved_by') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Accreditation</label>
                        <input type="text" class="form-control" name="univ_accreditation" placeholder="e.g., NAAC A+"
                            required value="{{ old('univ_accreditation', $university['univ_accreditation'] ?? '') }}">
                        @error('univ_accreditation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Programs Offered</label>
                        <textarea class="form-control" name="univ_programs_offered" rows="3"
                            placeholder="List of programs offered by the university">{{ old('univ_programs_offered', $university['univ_programs_offered'] ?? '') }}</textarea>
                        @error('univ_programs_offered') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University Logo</label>
                        @if(!empty($university['univ_logo']))
                            <div class="mb-2">
                                <img src="{{ !empty($university['univ_logo']) ? '/images/university/logo/' . $university['univ_logo'] : '/images/logomini.png' }}"
                                    alt="{{ $university['univ_name'] }}"
                                    class="img-fluid rounded shadow object-fit-cover object-position-center" style="height: 200px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_logo" id="remove_logo">
                                    <label class="form-check-label" for="remove_logo">Remove current logo</label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" name="univ_logo" accept="image/*">
                        <small class="text-muted">Leave blank to keep current. Recommended size: 200x200px, Max size:
                            2MB</small>
                        @error('univ_logo') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University Banner</label>
                        @if(!empty($university['univ_image']))
                            <div class="mb-2">
                                <img src="{{ !empty($university['univ_image']) ? '/images/university/campus/' . $university['univ_image'] : '/images/logomini.png' }}"
                                    alt="{{ $university['univ_name'] }}"
                                    class="img-fluid rounded shadow object-fit-cover object-position-center" style="height: 200px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_banner" id="remove_banner">
                                    <label class="form-check-label" for="remove_banner">Remove current banner</label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" name="univ_image" accept="image/*">
                        <small class="text-muted">Leave blank to keep current. Recommended size: 1200x400px, Max size:
                            5MB</small>
                        @error('univ_image') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gallery Images</label>
                        @if(isset($university_galleries) && $university_galleries->count() > 0)
                            <div class="row mb-3">
                                @foreach($university_galleries as $image)
                                    <div class="col-md-3 mb-2 position-relative">
                                        <img src="{{ !empty($image->image_path) ? asset($image->image_path) : asset('/images/logomini.png') }}"
                                            alt="Gallery Image" class="img-fluid rounded shadow object-fit-cover object-position-center" style="height: 200px;">
                                        <div class="form-check position-absolute" style="top: 5px; right: 5px;">
                                            <input class="form-check-input" type="checkbox" name="deleted_gallery[]"
                                                value="{{ $image->id }}" id="delete_gallery_{{ $image->id }}">
                                            <label class="form-check-label" for="delete_gallery_{{ $image->id }}"
                                                style="display: none;">Delete</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" class="form-control" name="univ_gallery[]" multiple accept="image/*">
                        <small class="text-muted">Upload additional images. You can select multiple images. Max size per
                            image: 5MB</small>
                        @error('univ_gallery.*') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                </div>
            </section>

            {{-- Hidden Courses --}}
            @foreach ($university['courses'] as $course)
                <input type="hidden" name="courses[]" value="{{ $course['id'] }}">
            @endforeach

            {{-- Submit Button --}}
            <div class="text-end py-3">
                <button type="submit" class="btn btn-primary btn-lg px-4">Update University</button>
            </div>
        </form>
    </main>

    @push('style')
        <style>
            .page_title {
                font-size: 1.6rem;
                font-weight: 600;
            }

            .section_title {
                font-size: 1.2rem;
                margin-bottom: 1rem;
                color: #495057;
            }

            .input-group .btn {
                white-space: nowrap;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Country, State, City Dropdowns
                $('#country_id').on('change', function () {
                    var countryId = $(this).val();
                    if (countryId) {
                        $.ajax({
                            url: '/admin/get-states/' + countryId,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#state_id').empty();
                                $('#state_id').append('<option value="" disabled>--- Select State ---</option>');
                                $.each(data, function (key, value) {
                                    $('#state_id').append('<option value="' + key + '">' + value + '</option>');
                                });
                                $('#city_id').empty().append('<option value="" disabled>--- Select City ---</option>');
                            }
                        });
                    } else {
                        $('#state_id').empty().append('<option value="" disabled>--- Select State ---</option>');
                        $('#city_id').empty().append('<option value="" disabled>--- Select City ---</option>');
                    }
                });

                $('#state_id').on('change', function () {
                    var stateId = $(this).val();
                    if (stateId) {
                        $.ajax({
                            url: '/admin/get-cities/' + stateId,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#city_id').empty();
                                $('#city_id').append('<option value="" disabled>--- Select City ---</option>');
                                $.each(data, function (key, value) {
                                    $('#city_id').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#city_id').empty().append('<option value="" disabled>--- Select City ---</option>');
                    }
                });

                // Add/Remove Key Facts
                $('#add-fact').click(function () {
                    $('#key-facts').append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="facts[]" placeholder="Enter a key fact">
                            <button type="button" class="btn btn-outline-danger remove-fact">Remove</button>
                        </div>
                    `);
                });

                // Add/Remove Industry Connections
                $('#add-industry').click(function () {
                    $('#industry-connections').append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="industry[]" placeholder="Enter industry connection">
                            <button type="button" class="btn btn-outline-danger remove-industry">Remove</button>
                        </div>
                    `);
                });

                // Add/Remove Career Opportunities
                $('#add-career').click(function () {
                    $('#career-opportunities').append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="carrier[]" placeholder="Enter career opportunity">
                            <button type="button" class="btn btn-outline-danger remove-career">Remove</button>
                        </div>
                    `);
                });

                // Add/Remove Advantages
                $('#add-advantage').click(function () {
                    $('#advantages').append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="advantages[]" placeholder="Enter advantage">
                            <button type="button" class="btn btn-outline-danger remove-advantage">Remove</button>
                        </div>
                    `);
                });

                // Remove buttons (using event delegation for dynamically added elements)
                $(document).on('click', '.remove-fact, .remove-industry, .remove-career, .remove-advantage', function () {
                    // Only remove if there's more than one input group
                    if ($(this).closest('.input-group').siblings('.input-group').length > 0) {
                        $(this).closest('.input-group').remove();
                    } else {
                        // If it's the last one, just clear the input
                        $(this).siblings('input[type="text"]').val('');
                    }
                });

                // Initialize Select2 if available
                if ($.fn.select2) {
                    $('select').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }
            });
        </script>
    @endpush


    @push('script')
        <script>
            function display_pic(node) {
                $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
            }

            // Function to load states based on selected country
            function loadStates(countryId, selectedStateId = null) {
                const stateSelect = document.getElementById('state_id');
                stateSelect.innerHTML = '<option value="" disabled selected>--- Select State ---</option>';

                if (!countryId) {
                    // Reset city select if no country is selected
                    document.getElementById('city_id').innerHTML = '<option value="" disabled selected>--- Select City ---</option>';
                    return;
                }

                // Show loading state
                stateSelect.disabled = true;

                // Fetch states for the selected country
                fetch(`/api/states/${countryId}`)
                    .then(response => response.json())
                    .then(states => {
                        states.forEach(state => {
                            const option = new Option(state.name, state.id);
                            if (selectedStateId && state.id == selectedStateId) {
                                option.selected = true;
                            }
                            stateSelect.add(option);
                        });
                        stateSelect.disabled = false;

                        // If a state was previously selected, load its cities
                        if (selectedStateId) {
                            loadCities(selectedStateId, '{{ $university["city_id"] ?? "" }}');
                        }
                    });
            }

            // Function to load cities based on selected state
            function loadCities(stateId, selectedCityId = null) {
                const citySelect = document.getElementById('city_id');
                citySelect.innerHTML = '<option value="" disabled selected>--- Select City ---</option>';

                if (!stateId) return;

                // Show loading state
                citySelect.disabled = true;

                // Fetch cities for the selected state
                fetch(`/api/cities/${stateId}`)
                    .then(response => response.json())
                    .then(cities => {
                        cities.forEach(city => {
                            const option = new Option(city.name, city.id);
                            if (selectedCityId && city.id == selectedCityId) {
                                option.selected = true;
                            }
                            citySelect.add(option);
                        });
                        citySelect.disabled = false;
                    });
            }

            // Initialize the form
            document.addEventListener('DOMContentLoaded', function () {
                // Set up country change event
                const countrySelect = document.getElementById('country_id');
                if (countrySelect) {
                    countrySelect.addEventListener('change', function () {
                        loadStates(this.value);
                    });
                }

                // Set up state change event
                const stateSelect = document.getElementById('state_id');
                if (stateSelect) {
                    stateSelect.addEventListener('change', function () {
                        loadCities(this.value);
                    });
                }

                // If there's a previously selected country (editing existing university), load its states
                const selectedCountryId = '{{ $university["country_id"] ?? "" }}';
                const selectedStateId = '{{ $university["state_id"] ?? "" }}';

                if (selectedCountryId) {
                    loadStates(selectedCountryId, selectedStateId);
                }

                // Initialize search functionality for courses
                document.querySelectorAll('.search-course').forEach(function (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const searchTerm = this.value.toLowerCase();
                        const category = this.getAttribute('data-category');

                        // Find all course items in this category
                        const courseItems = document.querySelectorAll(`.course-item.${category}`);

                        courseItems.forEach(function (item) {
                            const courseName = item.getAttribute('title').toLowerCase();
                            if (courseName.includes(searchTerm)) {
                                item.classList.remove('hidden');
                            } else {
                                item.classList.add('hidden');
                            }
                        });

                        // Show/hide subcategory sections based on visible courses
                        document.querySelectorAll(`.subcategory-section`).forEach(function (section) {
                            const hasVisibleCourses = section.querySelector(`.course-item.${category}:not(.hidden)`);
                            section.style.display = hasVisibleCourses ? 'block' : 'none';
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
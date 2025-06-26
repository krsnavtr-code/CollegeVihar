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
@endphp
@extends('admin.components.layout')
@section('title', 'Edit University - CV Admin')

@section('main')
    <main class="container py-4">
    @include('admin.components.response')

    <form action="/admin/university/edit" method="post">
        @csrf
        <input type="hidden" name="univ_id" value="{{ $university['id'] }}">

        <h5 class="page_title mb-2">Edit University</h5>
        <p class="text-muted text-center">You are editing <b class="text-primary">{{ $university['univ_name'] }}</b></p>

        <section class="panel mt-4">
            <h6 class="section_title">University Details</h6>

            {{-- University Name & URL --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">University Name</label>
                    <input type="text" name="univ_name" class="form-control" placeholder="University Name" value="{{ $university['univ_name'] }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">University URL</label>
                    <input type="text" name="univ_url" class="form-control" placeholder="University URL" value="{{ $university['univ_url'] }}" required>
                </div>
            </div>

            {{-- Type & Category --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">University Type</label>
                    <select name="univ_type" class="form-select" required>
                        <option disabled selected>--- Please Select ---</option>
                        <option value="offline" {{ $university['univ_type'] === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ $university['univ_type'] === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">University Category</label>
                    <select name="univ_category" class="form-select" required>
                        <option disabled>-- Please Select --</option>
                        @php $cat = strtolower($university['univ_category'] ?? '') @endphp
                        <option value="central university" {{ $cat === 'central university' ? 'selected' : '' }}>Central University</option>
                        <option value="state university" {{ $cat === 'state university' ? 'selected' : '' }}>State University</option>
                        <option value="state private university" {{ $cat === 'state private university' ? 'selected' : '' }}>State Private University</option>
                        <option value="state public university" {{ $cat === 'state public university' ? 'selected' : '' }}>State Public University</option>
                        <option value="deemed university" {{ $cat === 'deemed university' ? 'selected' : '' }}>Deemed University</option>
                        <option value="autonomous institute" {{ $cat === 'autonomous institute' ? 'selected' : '' }}>Autonomous Institute</option>
                    </select>
                </div>
            </div>

            {{-- Country, State, City --}}
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <select name="country_id" id="country_id" class="form-select" required>
                        <option disabled selected>--- Select Country ---</option>
                        @foreach (\App\Models\Country::all() as $country)
                            <option value="{{ $country->id }}" {{ $university['country_id'] == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <select name="state_id" id="state_id" class="form-select" required>
                        <option disabled selected>--- Select State ---</option>
                        @if(isset($university['country_id']))
                            @foreach (\App\Models\State::where('country_id', $university['country_id'])->get() as $state)
                                <option value="{{ $state->id }}" {{ $university['state_id'] == $state->id ? 'selected' : '' }}>
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
                        <option disabled selected>--- Select City ---</option>
                        @if(isset($university['state_id']))
                            @foreach (\App\Models\City::where('state_id', $university['state_id'])->get() as $city)
                                <option value="{{ $city->id }}" {{ $university['city_id'] == $city->id ? 'selected' : '' }}>
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
                <input type="text" name="univ_address" class="form-control" placeholder="University Address" value="{{ $university['univ_address'] }}" required>
                @error('univ_address') <small class="text-danger">{{ $message }}</small> @enderror
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
</style>
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
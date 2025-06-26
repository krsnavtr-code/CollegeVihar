@php
    // Course categories are passed from the controller
@endphp

@extends('admin.components.layout')
@section('title', 'Add University - CV Admin')

@section('main')
    <main class="container py-4">
        @include('admin.components.response')

        <form action="/admin/university/add" method="post">
            @csrf
            <h5 class="page_title mb-3">Add University</h5>
            <p class="text-muted text-center mb-4">You can add a university here by filling out the form. <b
                    class="text-primary">College Vihar</b> will add the university to the database.</p>

            {{-- Response messages --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="panel">
                {{-- Name & URL --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">University Name <i class="text-muted">(Full Name)</i></label>
                        <input type="text" class="form-control" name="univ_name" placeholder="University Name" required>
                        @error('univ_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University URL <em>(University Website URL)</em></label>
                        <input type="text" class="form-control" name="univ_url" placeholder="University URL" required>
                        @error('univ_url') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Type & Category --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">University Type</label>
                        <select class="form-select" name="univ_type" required>
                            <option disabled selected>--- Please Select ---</option>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University Category</label>
                        <select class="form-select" name="univ_category" required>
                            <option disabled selected>--- Please Select ---</option>
                            <option value="central university">Central University</option>
                            <option value="state university">State University</option>
                            <option value="state private university">State Private University</option>
                            <option value="state public university">State Public University</option>
                            <option value="deemed university">Deemed University</option>
                            <option value="autonomous institute">Autonomous Institute</option>
                        </select>
                    </div>
                </div>

                {{-- Country, State, City --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <select class="form-select" name="country_id" id="country_id" required>
                            <option disabled selected>--- Select Country ---</option>
                            @foreach (\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <select class="form-select" name="state_id" id="state_id" required>
                            <option disabled selected>--- Select State ---</option>
                            @if(old('country_id'))
                                @foreach (\App\Models\State::where('country_id', old('country_id'))->get() as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('state_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select class="form-select" name="city_id" id="city_id" required>
                            <option disabled selected>--- Select City ---</option>
                            @if(old('state_id'))
                                @foreach (\App\Models\City::where('state_id', old('state_id'))->get() as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
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
                    <input type="text" class="form-control" name="univ_address" placeholder="University Address" required>
                    @error('univ_address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </section>

            <input type="hidden" name="courses[]" value="">

            <div class="text-center py-3">
                <button type="submit" class="btn btn-primary btn-lg px-4">Add University</button>
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
                font-size: 1.1rem;
                color: #6c757d;
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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load states');
                        }
                        return response.json();
                    })
                    .then(states => {
                        // Clear existing options
                        stateSelect.innerHTML = '<option value="" disabled selected>--- Select State ---</option>';

                        // Add states to the select
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
                            loadCities(selectedStateId, '{{ old("city_id") }}');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading states:', error);
                        stateSelect.disabled = false;
                    });
            }

            // Function to load cities based on selected state
            function loadCities(stateId, selectedCityId = null) {
                const citySelect = document.getElementById('city_id');
                citySelect.innerHTML = '<option value="" disabled selected>--- Select City ---</option>';

                if (!stateId) {
                    citySelect.disabled = false;
                    return;
                }

                // Show loading state
                citySelect.disabled = true;

                // Fetch cities for the selected state
                fetch(`/api/cities/${stateId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load cities');
                        }
                        return response.json();
                    })
                    .then(cities => {
                        // Clear existing options
                        citySelect.innerHTML = '<option value="" disabled selected>--- Select City ---</option>';

                        // Add cities to the select
                        if (cities && cities.length > 0) {
                            cities.forEach(city => {
                                const option = new Option(city.name, city.id);
                                if (selectedCityId && city.id == selectedCityId) {
                                    option.selected = true;
                                }
                                citySelect.add(option);
                            });
                        } else {
                            // Add a disabled option if no cities are found
                            const option = new Option('No cities found', '');
                            option.disabled = true;
                            citySelect.add(option);
                        }

                        citySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);

                        // Add error message
                        const option = new Option('Error loading cities', '');
                        option.disabled = true;
                        citySelect.innerHTML = '';
                        citySelect.add(option);
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

                // If there's a previously selected country (form validation failed), load its states
                const selectedCountryId = '{{ old("country_id") }}';
                const selectedStateId = '{{ old("state_id") }}';

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
@php
// Course categories are passed from the controller
@endphp

@extends('admin.components.layout')
@section('title', 'Add University - CV Admin')

@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/university/add" method="post">
            <div class="d-flex justify-content-around mb-3">
                <h5 class="page_title">Add University</h5>
                <h6 class="section_title text-danger">University Information</h6>
            </div>
            <section class="panel">
                @csrf
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="field_group">
                    <div class="field">
                        <label for="">University Name <i class="text">( Full Name )</i></label>
                        <input type="text" placeholder="University Name" name="univ_name" required>
                        @error('univ_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="">University Url</label>
                        <input type="text" placeholder="University Url" name="univ_url" required>

                        @error('univ_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="">University Type</label>
                        <select name="univ_type" id="" required>
                            <option value="" selected disabled>--- Please Select ---</option>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="">University Category</label>
                        <select name="univ_category" id="" required>
                            <option value="" selected disabled>--- Please Select ---</option>
                            <option value="central university">Central University</option>
                            <option value="state university">State University</option>
                            <option value="state private university">State Private University</option>
                            <option value="state public university">State Public University</option>
                            <option value="deemed university">Deemed University</option>
                            <option value="autonomous institude">Autonomous Institute</option>
                        </select>
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="country_id">Country</label>
                        <select name="country_id" id="country_id" required>
                            <option value="" disabled selected>--- Select Country ---</option>
                            @foreach (\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="state_id">State</label>
                        <select name="state_id" id="state_id" required>
                            <option value="" disabled selected>--- Select State ---</option>
                            @if(old('country_id'))
                                @foreach (\App\Models\State::where('country_id', old('country_id'))->get() as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="city_id">City</label>
                        <select name="city_id" id="city_id" required>
                            <option value="" disabled selected>--- Select City ---</option>
                            @if(old('state_id'))
                                @foreach (\App\Models\City::where('state_id', old('state_id'))->get() as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="univ_address">University Address</label>
                        <textarea name="univ_address" id="univ_address" placeholder="Full address" required>{{ old('univ_address') }}</textarea>
                        @error('univ_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="field_group">
                    <div class="field cflex">
                        <label for="address">University Complete Address</label>
                        <input type="text" id="address" placeholder="University Address" name="univ_address" required>
                        @error('univ_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>
            <!-- @foreach($courseCategories as $category => $categoryData)
            <section class="card p-2 mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">{{ $categoryData['label'] }}</h3>
                    <input type="search" 
                           class="search-course form-input rounded-full border-gray-300" 
                           data-category="{{ $category }}" 
                           placeholder="Search {{ $category }} Courses">
                </div>
                
                @php
                    $hasCourses = false;
                    // Check if any courses exist for this category
                    foreach($categoryData['subcategories'] as $subcategory) {
                        if(isset($coursesByType[$subcategory]) && count($coursesByType[$subcategory]) > 0) {
                            $hasCourses = true;
                            break;
                        }
                    }
                @endphp
                
                @if($hasCourses)
                    @foreach($categoryData['subcategories'] as $subcategory)
                        @php
                            $filteredCourses = [];
                            if(isset($coursesByType[$subcategory])) {
                                $filteredCourses = array_filter($coursesByType[$subcategory], function($course) use ($category) {
                                    return $course['course_type'] === $category || 
                                          ($category === 'DIPLOMA' && $course['course_type'] === 'Diploma') ||
                                          ($category === 'CERTIFICATION' && $course['course_type'] === 'Certification');
                                });
                            }
                        @endphp
                        
                        @if(count($filteredCourses) > 0)
                        <div class="subcategory-section mb-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-3 text-gray-700">
                                <i class="fas fa-chevron-right mr-2"></i>
                                {{ ucfirst(strtolower($subcategory)) }} Courses
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($filteredCourses as $course)
                                    <div class="course-item {{ $category }} {{ $subcategory }} flex items-center p-2 hover:bg-gray-100 rounded" 
                                         title="{{ $course['course_name'] }}">
                                        <input type="checkbox" 
                                               class="form-checkbox h-5 w-5 text-blue-600"
                                               name="courses[]" 
                                               value="{{ $course['id'] }}" 
                                               id="f{{ $course['id'] }}">
                                        <label for="f{{ $course['id'] }}" class="ml-2 text-sm text-gray-700 cursor-pointer hover:text-blue-600">
                                            <span class="font-medium">{{ $course['course_short_name'] }}</span> - 
                                            <span class="text-gray-600">{{ $course['course_name'] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-gray-500 italic py-4 text-center">
                        No courses available for this category
                    </div>
                @endif
            </section>
            @endforeach -->

            <input type="hidden" name="courses[]" value="">
            <div class="text-center p-4">
                <button type="submit" class="btn btn-primary btn-lg">Add University</button>
            </div>
        </form>
    </main>
    @push('style')
    <style>
        .course-item {
            display: block;
            margin: 4px 0;
        }
        .course-item.hidden {
            display: none;
        }
        .subcategory-section {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }
        .search-course {
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 50rem;
            width: 250px;
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
        document.addEventListener('DOMContentLoaded', function() {
            // Set up country change event
            const countrySelect = document.getElementById('country_id');
            if (countrySelect) {
                countrySelect.addEventListener('change', function() {
                    loadStates(this.value);
                });
            }
            
            // Set up state change event
            const stateSelect = document.getElementById('state_id');
            if (stateSelect) {
                stateSelect.addEventListener('change', function() {
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
            document.querySelectorAll('.search-course').forEach(function(searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const category = this.getAttribute('data-category');
                    
                    // Find all course items in this category
                    const courseItems = document.querySelectorAll(`.course-item.${category}`);
                    
                    courseItems.forEach(function(item) {
                        const courseName = item.getAttribute('title').toLowerCase();
                        if (courseName.includes(searchTerm)) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                    
                    // Show/hide subcategory sections based on visible courses
                    document.querySelectorAll(`.subcategory-section`).forEach(function(section) {
                        const hasVisibleCourses = section.querySelector(`.course-item.${category}:not(.hidden)`);
                        section.style.display = hasVisibleCourses ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
    @endpush
@endsection
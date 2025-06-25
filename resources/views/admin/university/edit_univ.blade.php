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
<main>
    <!-- http://localhost:8000/admin/university/edit/34 -->
    @include('admin.components.response')
    <form action="/admin/university/edit" method="post">
        <h2 class="page_title">Edit University</h2>
        <section class="panel">
            @csrf
            <input type="hidden" name="univ_id" value="{{ $university['id'] }}">
            <h3 class="section_title left">University Details</h3>
            <div class="field_group">
                <div class="field">
                    <label for="">University Name</label>
                    <input type="text" placeholder="University Name" name="univ_name"
                        value="{{ $university['univ_name'] }}">
                </div>
                <div class="field">
                    <label for="">University Url</label>
                    <input type="text" placeholder="University Url" name="univ_url"
                        value="{{ $university['univ_url'] }}">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="univ_type">University Type</label>
                    <select name="univ_type" id="univ_type" required>
                        <option value="" selected disabled>--- Please Select ---</option>
                        <option value="offline" {{ $university['univ_type'] === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ $university['univ_type'] === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="field">
                    <label for="univ_category">University Category</label>
                    <select name="univ_category" id="univ_category" required>
                        <option value="" {{ empty($university['univ_category']) ? 'selected' : '' }}>-- Please Select --</option>
                        <option value="central university" {{ strtolower($university['univ_category'] ?? '') === 'central university' ? 'selected' : '' }}>Central University</option>
                        <option value="state university" {{ strtolower($university['univ_category'] ?? '') === 'state university' ? 'selected' : '' }}>State University</option>
                        <option value="state private university" {{ strtolower($university['univ_category'] ?? '') === 'state private university' ? 'selected' : '' }}>State Private University</option>
                        <option value="state public university" {{ strtolower($university['univ_category'] ?? '') === 'state public university' ? 'selected' : '' }}>State Public University</option>
                        <option value="deemed university" {{ strtolower($university['univ_category'] ?? '') === 'deemed university' ? 'selected' : '' }}>Deemed University</option>
                        <option value="autonomous institute" {{ strtolower($university['univ_category'] ?? '') === 'autonomous institute' ? 'selected' : '' }}>Autonomous Institute</option>
                    </select>
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="country_id">Country</label>
                    <select name="country_id" id="country_id" required>
                        <option value="" disabled>--- Select Country ---</option>
                        @foreach (\App\Models\Country::all() as $country)
                            <option value="{{ $country->id }}" {{ (isset($university['country_id']) && $university['country_id'] == $country->id) ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
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
                        @if(isset($university['country_id']))
                            @foreach (\App\Models\State::where('country_id', $university['country_id'])->get() as $state)
                                <option value="{{ $state->id }}" {{ (isset($university['state_id']) && $university['state_id'] == $state->id) ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
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
                        @if(isset($university['state_id']))
                            @foreach (\App\Models\City::where('state_id', $university['state_id'])->get() as $city)
                                <option value="{{ $city->id }}" {{ (isset($university['city_id']) && $university['city_id'] == $city->id) ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('city_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                    @error('univ_city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="field_group">
                <div class="field cflex">
                    <label for="address">University Complete Address</label>
                    <input type="text" id="address" placeholder="University Address" name="univ_address" 
                           value="{{ $university['univ_address'] ?? '' }}" required>
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
                                           id="f{{ $course['id'] }}" 
                                           @if(in_array($course['id'], $added)) checked @endif>
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
        
        @foreach ($university['courses'] as $course)
        <input type="hidden" name="courses[]" value="{{ $course['id'] }}">
        @endforeach
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update University</button>
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
        fetch(`/admin/api/states/${countryId}`)
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
        fetch(`/admin/api/cities/${stateId}`)
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
        
        // If there's a previously selected country (editing existing university), load its states
        const selectedCountryId = '{{ $university["country_id"] ?? "" }}';
        const selectedStateId = '{{ $university["state_id"] ?? "" }}';
        
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
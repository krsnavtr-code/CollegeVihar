@php
$page_title = 'University List';
$current_state = $state->name ?? Request::segment(2);
@endphp

@extends('user.info.layout')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/index.css') }}">
    <link rel="stylesheet" href="{{ url('/css/online-programs.css') }}">
    <link rel="stylesheet" href="{{ url('/css/show-uni-list.css') }}">
@endpush

@section('main_section')
        <main>
            <section>
                <div class="container">
                   <div class="row">
                    <div class="col-12">
                        <div class=" mb-3">
                            <!-- <h5 class="p-2 ">Advanced Filter</h5> -->
                            <form id="universityFilterForm" class="row g-3 mb-5">
                                <!-- Country Dropdown -->
                                 <!-- University Lisr are comming Uning These Filters, So Do not remove it -->
                                <div class="col-lg-3 col-md-6 col-12 d-none">
                                    <label for="country_id" class="form-label mb-0">Country</label>
                                    <select class="form-select" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ ($state->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- State Dropdown -->
                                <!-- University Lisr are comming Uning These Filters, So Do not remove it -->
                                <div class="col-lg-3 col-md-6 col-12 d-none">
                                    <label for="state_id" class="form-label mb-0">State</label>
                                    <select class="form-select" id="state_id" name="state_id">
                                        <option value="">Select State</option>
                                        @foreach($states as $stateItem)
                                            <option value="{{ $stateItem->id }}" {{ $state->id == $stateItem->id ? 'selected' : '' }}>
                                                {{ $stateItem->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- City Dropdown -->
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="city_id" class="form-label mb-0">City</label>
                                    <select class="form-select" id="city_id" name="city_id">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- University Category Dropdown -->
                                <!-- University Lisr are comming Uning These Filters, So Do not remove it -->
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="univ_category" class="form-label mb-0">University Category</label>
                                    <select class="form-select" id="univ_category" name="univ_category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Course Type Dropdown -->
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="courseType" class="form-label mb-0">Course Type</label>
                                    <select class="form-select" id="courseType" name="course_type">
                                        <option value="">All Course Types</option>
                                        @if(isset($courseTypes) && count($courseTypes) > 0)
                                            @foreach($courseTypes as $type)
                                                @if(!empty($type))
                                                    <option value="{{ $type }}" {{ old('course_type') == $type ? 'selected' : '' }}>
                                                        {{ ucwords(str_replace('_', ' ', $type)) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Courses Dropdown (Dynamic) -->
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="courses" class="form-label mb-0">Courses</label>
                                    <select class="form-select" id="courses" name="courses">
                                        <option value="">Select Course</option>
                                        <!-- Options will be populated dynamically via JS -->
                                    </select>
                                </div>

                                <!-- University Name Input -->
                                <!-- University Lisr are comming Uning These Filters, So Do not remove it -->
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="search" class="form-label mb-0">Search University</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search" 
                                               placeholder="Search by name..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <div class="col-lg-6 col-md-6 col-12">
                                    <button type="submit" class="btn btn-primary w-100 mt-2">Filter</button>
                                </div>

                                <!-- Clear Filter Button -->
                                <div class="col-lg-6 col-md-6 col-12">
                                    <button type="button" class="btn btn-secondary w-100 mt-2" id="resetFilterButton">Clear Filter</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                    <div class="row">
                        @php
                            $state_univ = Request::get('state_univ', []);
                            $matched_state = collect($state_univ)->firstWhere('state_name', $current_state);
                            $courses = $matched_state ? collect($matched_state['universities'])->pluck('courses.*.course_name')->flatten()->unique() : [];
                            $university_count = $matched_state ? count($matched_state['universities']) : 0;
                        @endphp

                        @if ($matched_state && $university_count > 0)
                            <aside class="col-md-3">
                                <!-- New Filter Section (Above the existing Filter by Course) -->


                                <!-- Existing Filter by Course (Unchanged) -->
                                <div class="filter-box">
                                    <h5 class="p-2 bg-blue">Filter by Course</h5>
                                    <ul class="filter">
                                        <li>
                                            <a type="button" class="filter-btn active" data-filter="all">All Courses</a>
                                        </li>

                                        @foreach ($courses as $course)
                                            <li>
                                                <a type="button" class="filter-btn" data-filter="{{ $course }}">{{ $course }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </aside>

                            <div class="col-md-9">
                                <h3 class="blue">We have found {{ $university_count }} universities for you in {{ ucfirst($current_state) }} State</h3>
                                <div id="universityList">
                                    <!-- University List are generated dynamically -->
                                    <!-- @foreach ($matched_state['universities'] as $univ)
                                        @php
                                            $courses = $univ['courses'] ?? [];
                                            $courseNames = array_column($courses, 'course_name');
                                            $metadata = $univ['metadata'] ?? [];
                                        @endphp
                                        <article class="card on-card mb-2 filter-card"
                                            data-courses="{{ !empty($courseNames) ? implode(',', $courseNames) : '' }}"
                                            data-category="{{ $univ['univ_category'] ?? '' }}"
                                            data-course-type="{{ $univ['course_type'] ?? '' }}"
                                            data-name="{{ strtolower($univ['univ_name']) }}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img class="img-fluid rounded-1"
                                                        src="{{ asset('images/university/campus/' . ($univ['univ_image'] ?? '')) }}"
                                                        alt="{{ $univ['univ_name'] ?? '' }}">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="text-box">
                                                        <div class="between">
                                                            <div>
                                                                <h6>
                                                                    <a class="blue" href="/{{ $metadata['url_slug'] ?? '#' }}">
                                                                        {{ $univ['univ_name'] ?? '' }}
                                                                    </a>
                                                                </h6>
                                                                <p><i class="fa-solid fa-location-dot"></i> {{ $univ['univ_address'] ?? '' }}</p>
                                                            </div>
                                                            <div class="flex">
                                                                <button class="btn btn-outline-secondary rounded-pill com-btn">
                                                                    <small>Compare</small>
                                                                    <i class="fa-regular fa-window-restore"></i>
                                                                </button>
                                                                <button class="btn btn-outline-secondary rounded-pill">
                                                                    <i class="fa-solid fa-bookmark"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="between">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p>Courses Offered</p>
                                                                    <h6>{{ $univ->courses_count ?? 0 }} Courses</h6>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>Tuition Fees</p>
                                                                    <h6><i class="fa-solid fa-indian-rupee-sign"></i> Starts From {{ collect($univ['courses'])->pluck('pivot.univ_course_fee')->filter()->first() ?? 'N/A' }}</h6>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>Exams Accepted</p>
                                                                    <h6>JEE, NEET, +2</h6>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>Mode</p>
                                                                    <h6>
                                                                        @if ($univ['univ_type'] === 'online')
                                                                            <i class="fa-solid fa-desktop fa-xs"></i> Online Class
                                                                        @else
                                                                            <i class="fa-solid fa-school fa-xs"></i> Offline Class
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <div class="row p-2">
                                                                <div class="col-sm-12 col-6">
                                                                    <a href="{{ route('download-pdf', ['filename' => 'prospectus_collegevihar.pdf']) }}"
                                                                        class="btn btn-outline-danger rounded-pill w-100">
                                                                        <i class="fa-solid fa-download"></i>
                                                                        <small>Brochure</small>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-12 col-6">
                                                                    <a class="btn btn-primary rounded-pill w-100" href="#"
                                                                        data-bs-toggle="modal" data-bs-target="#applyModal">
                                                                        <small>Apply Now</small>
                                                                        <i class="fa-solid fa-up-right-from-square fa-xs"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach -->
                                </div>
                            </div>
                        @else
                            <div class="col-md-12">
                                <p class="text-center">No universities found for this region/state.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        @push('script')
      <script>
         document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const countrySelect = document.getElementById('country_id');
            const stateSelect = document.getElementById('state_id');
            const citySelect = document.getElementById('city_id');
            const courseTypeSelect = document.getElementById('courseType');
            const coursesSelect = document.getElementById('courses');
            const filterForm = document.getElementById('universityFilterForm');
            const resetFilterButton = document.getElementById('resetFilterButton');
            const universityList = document.getElementById('universityList');
            
            // Current state from PHP
            const currentStateId = '{{ $state->id ?? "" }}';
            const currentStateName = '{{ $state->name ?? "" }}';
            
            // Function to load states based on selected country
            function loadStates(countryId, selectedStateId = null) {
                if (!stateSelect) return;
                
                stateSelect.innerHTML = '<option value="">Select State</option>';
                if (citySelect) citySelect.innerHTML = '<option value="">Select City</option>';
                
                if (!countryId) return;
                
                // Show loading state
                stateSelect.disabled = true;
                if (citySelect) citySelect.disabled = true;
                
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
                            loadCities(selectedStateId);
                        } else if (currentStateId) {
                            // If we have a current state from the URL, select it
                            stateSelect.value = currentStateId;
                            loadCities(currentStateId);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading states:', error);
                        stateSelect.disabled = false;
                    });
            }
            
            // Function to load cities based on selected state
            function loadCities(stateId, selectedCityId = null) {
                if (!citySelect) return;
                
                citySelect.innerHTML = '<option value="">Loading cities...</option>';
                citySelect.disabled = true;
                
                if (!stateId) {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    citySelect.disabled = false;
                    return;
                }
                
                // Fetch cities for the selected state
                fetch(`/api/states/${stateId}/cities`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load cities');
                        }
                        return response.json();
                    })
                    .then(cities => {
                        citySelect.innerHTML = '<option value="">All Cities</option>';
                        
                        cities.forEach(city => {
                            const option = new Option(city.name, city.id);
                            
                            // Check if this city should be selected
                            if ((selectedCityId && city.id == selectedCityId) || 
                                (!selectedCityId && citySelect.dataset.selectedCityId == city.id)) {
                                option.selected = true;
                            }
                            
                            citySelect.add(option);
                        });
                        
                        citySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                        citySelect.innerHTML = '<option value="">Error loading cities</option>';
                        citySelect.disabled = false;
                    });
            }
            
            // Initialize event listeners
            function initializeEventListeners() {
                // Country change event
                if (countrySelect) {
                    countrySelect.addEventListener('change', function() {
                        const countryId = this.value;
                        loadStates(countryId);
                        // Reset state and city when country changes
                        if (stateSelect) stateSelect.innerHTML = '<option value="">Select State</option>';
                        if (citySelect) citySelect.innerHTML = '<option value="">Select City</option>';
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                }
                
                // State change event
                if (stateSelect) {
                    stateSelect.addEventListener('change', function() {
                        const stateId = this.value;
                        if (citySelect) citySelect.innerHTML = '<option value="">Loading cities...</option>';
                        loadCities(stateId);
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                }
                
                // City change event
                if (citySelect) {
                    citySelect.addEventListener('change', function() {
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                }
                
                // Other filter changes
                const filterInputs = filterForm.querySelectorAll('select[name^="univ_"], select[name^="course_"], input[name^="search"]');
                filterInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        filterForm.dispatchEvent(new Event('submit'));
                    });
                });
            }
            
            // Handle city change
            if (citySelect) {
                citySelect.addEventListener('change', function() {
                    filterForm.dispatchEvent(new Event('submit'));
                });
            }
            
            // Handle other filter changes
            const filterInputs = filterForm.querySelectorAll('select[name^="univ_"], select[name^="course_"], input[name^="search"]');
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    filterForm.dispatchEvent(new Event('submit'));
                });
            });
            
            // Handle form submission with AJAX
            function handleFormSubmit(e) {
                e.preventDefault();
                filterUniversities();
            }
            
            // Initialize the application
            function init() {
                // Set up form submission
                if (filterForm) {
                    // Set up all event listeners first
                    initializeEventListeners();
                    
                    // Get URL parameters
                    const urlParams = new URLSearchParams(window.location.search);
                    const countryId = urlParams.get('country_id');
                    const stateId = urlParams.get('state_id');
                    const cityId = urlParams.get('city_id');
                    
                    // Set selected values from URL parameters
                    if (countryId && countrySelect) {
                        countrySelect.value = countryId;
                        loadStates(countryId, stateId);
                    }
                    
                    if (stateId && stateSelect) {
                        stateSelect.value = stateId;
                        loadCities(stateId, cityId);
                    }
                    
                    // Set other filter values from URL
                    const filterInputs = {
                        'univ_category': 'univ_category',
                        'course_type': 'courseType',
                        'search': 'search'
                    };
                    
                    Object.entries(filterInputs).forEach(([param, id]) => {
                        const value = urlParams.get(param);
                        const element = document.getElementById(id);
                        if (value && element) {
                            element.value = value;
                        }
                    });
                    
                    // Trigger initial filter after a short delay to allow DOM to update
                    setTimeout(() => {
                        filterUniversities();
                    }, 100);
                }
            }
            
            // Start the application when DOM is fully loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
            
            // Function to load states based on country
            function loadStates(countryId, selectedStateId = null) {
                if (!stateSelect) return;
                
                stateSelect.innerHTML = '<option value="">Loading states...</option>';
                stateSelect.disabled = true;
                
                if (!countryId) {
                    stateSelect.innerHTML = '<option value="">Select State</option>';
                    stateSelect.disabled = false;
                    if (citySelect) {
                        citySelect.innerHTML = '<option value="">Select City</option>';
                        citySelect.disabled = true;
                    }
                    return;
                }
                
                fetch(`/api/countries/${countryId}/states`)
                    .then(response => response.json())
                    .then(data => {
                        stateSelect.innerHTML = '<option value="">All States</option>';
                        
                        data.forEach(state => {
                            const option = new Option(state.name, state.id);
                            
                            // Check if this state should be selected
                            if ((selectedStateId && selectedStateId == state.id) || 
                                (!selectedStateId && stateSelect.dataset.selectedStateId == state.id)) {
                                option.selected = true;
                            }
                            
                            stateSelect.add(option);
                        });
                        
                        stateSelect.disabled = false;
                        
                        // If we have a selected state, load its cities
                        const stateId = selectedStateId || (stateSelect.value || null);
                        if (stateId) {
                            loadCities(stateId);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading states:', error);
                        stateSelect.innerHTML = '<option value="">Error loading states</option>';
                        stateSelect.disabled = false;
                    });
            }
            
            // Function to load cities based on state
            function loadCities(stateId) {
                if (!stateId || !citySelect) {
                    if (citySelect) citySelect.innerHTML = '<option value="">Select City</option>';
                    return;
                }
                
                fetch(`/api/states/${stateId}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">All Cities</option>';
                        
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            
                            // Check if this city should be selected
                            const urlParams = new URLSearchParams(window.location.search);
                            const selectedCityId = urlParams.get('city_id');
                            if (selectedCityId && selectedCityId == city.id) {
                                option.selected = true;
                            }
                            
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                    });
            }
            
            // Function to filter universities
            function filterUniversities() {
                if (!filterForm) return;
                
                const formData = new FormData(filterForm);
                const params = new URLSearchParams();
                
                // Append all form data to URLSearchParams
                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }
                
                // Update URL without page reload
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({}, '', newUrl);
                
                // Show loading spinner
                if (universityList) {
                    universityList.innerHTML = `
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading universities...</p>
                        </div>`;
                }
                
                // Show loading state
                if (universityList) {
                    universityList.innerHTML = `
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Searching universities...</p>
                        </div>`;
                }
                
                fetch(`/admin/api/universities/filter?${params.toString()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!universityList) return;
                        
                        // Clear current list
                        universityList.innerHTML = '';
                        
                        if (data.success && data.universities && data.universities.length > 0) {
                            data.universities.forEach((univ, index) => {
                                // Debug: Log the first university object
                                if (index === 0) {
                                    console.log('University object:', JSON.stringify(univ, null, 2));
                                }
                                const universityCard = document.createElement('article');
                                universityCard.className = 'card mb-4';
                                
                                // Build location string
                                const location = [];
                                if (univ.city && univ.city.name) location.push(univ.city.name);
                                if (univ.state && univ.state.name) location.push(univ.state.name);
                                
                                // Build badges
                                const badges = [];
                                if (univ.univ_category) {
                                    badges.push(`<span class="badge bg-primary me-1">${univ.univ_category}</span>`);
                                }
                                if (univ.univ_type) {
                                    badges.push(`<span class="badge bg-secondary">${univ.univ_type}</span>`);
                                }
                                
                                // Build courses list
                                let coursesHtml = '';
                                if (univ.courses && univ.courses.length > 0) {
                                    const courseNames = univ.courses
                                        .slice(0, 3)
                                        .map(c => `<span class="badge bg-light text-dark border me-1 mb-1">${c.course_name}</span>`)
                                        .join('');
                                    const moreCount = univ.courses.length > 3 ? 
                                        `<span class="badge bg-light text-dark border">+${univ.courses.length - 3} more</span>` : '';
                                    
                                    coursesHtml = `
                                        <div class="mt-2">
                                            <small class="d-block text-muted mb-1">Available Courses:</small>
                                            <div class="d-flex flex-wrap">
                                                ${courseNames}${moreCount}
                                            </div>
                                        </div>`;
                                }
                                
                                // Build the university card HTML
                                universityCard.innerHTML = `
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            ${univ.univ_image ? 
                                                `<img src="${univ.univ_image.startsWith('http') ? '' : '/images/university/campus/'}${univ.univ_image}" 
                                                    class="img-fluid rounded-start h-100 w-100" 
                                                    alt="${univ.univ_name || 'University'}"
                                                    style="object-fit: cover; min-height: 200px;">` :
                                                `<div class="bg-light d-flex align-items-center justify-content-center h-100" style="min-height: 200px;">
                                                    <i class="fas fa-university fa-3x text-muted"></i>
                                                </div>`
                                            }
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body h-100 d-flex flex-column">
                                                <div>
                                                    <h5 class="card-title mb-1">
                                                        <a href="/university/${univ.univ_name ? univ.univ_name.toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '') : univ.id}" class="text-decoration-none text-dark">
                                                            ${univ.univ_name || 'University Name Not Available'}
                                                        </a>
                                                    </h5>
                                                    ${location.length > 0 ? `
                                                    <p class="card-text mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            ${location.join(', ')}
                                                        </small>
                                                    </p>` : ''}
                                                    ${badges.length > 0 ? `
                                                    <div class="mb-2">
                                                        ${badges.join('')}
                                                    </div>` : ''}
                                                    ${univ.univ_description ? `
                                                    <p class="card-text mb-2 text-muted small">
                                                        ${univ.univ_description.length > 200 ? 
                                                            univ.univ_description.substring(0, 200) + '...' : 
                                                            univ.univ_description}
                                                    </p>` : ''}
                                                    ${coursesHtml}
                                                </div>
                                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                                    <div>
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="fas fa-graduation-cap me-1"></i>
                                                            ${univ.courses_count || 0} ${univ.courses_count === 1 ? 'Course' : 'Courses'}
                                                        </span>
                                                    </div>
                                                    <a href="/university/${univ.univ_name ? univ.univ_name.toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '') : univ.id}" class="btn btn-sm btn-primary">
                                                        View Details <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                
                                universityList.appendChild(universityCard);
                            });
                        } else {
                            // No universities found
                            universityList.innerHTML = `
                                <div class="text-center p-5">
                                    <i class="fas fa-university fa-4x text-muted mb-3"></i>
                                    <h4>No universities found</h4>
                                    <p class="text-muted mb-4">We couldn't find any universities matching your criteria.</p>
                                    <button class="btn btn-outline-primary" id="resetFiltersBtn">
                                        <i class="fas fa-sync-alt me-1"></i> Reset Filters
                                    </button>
                                </div>`;
                            
                            // Add event listener to reset filters button
                            const resetBtn = document.getElementById('resetFiltersBtn');
                            if (resetBtn) {
                                resetBtn.addEventListener('click', function() {
                                    // Reset form
                                    if (filterForm) {
                                        filterForm.reset();
                                        
                                        // Reset URL
                                        window.history.pushState({}, '', window.location.pathname);
                                        
                                        // Reload states and cities if country is selected
                                        if (countrySelect && countrySelect.value) {
                                            loadStates(countrySelect.value);
                                        } else if (stateSelect) {
                                            stateSelect.innerHTML = '<option value="">Select State</option>';
                                        }
                                        if (citySelect) {
                                            citySelect.innerHTML = '<option value="">Select City</option>';
                                        }
                                        
                                        // Trigger form submission to show all universities
                                        filterForm.dispatchEvent(new Event('submit'));
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching universities:', error);
                        if (universityList) {
                            universityList.innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    An error occurred while loading universities. Please try again later.
                                    <div class="mt-2 small text-muted">${error.message}</div>
                                </div>`;
                        }
                    });
            }
            
            // Initial load of states if country is pre-selected from URL
            // Initialize form if there are URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.toString()) {
                // Populate form fields from URL parameters
                urlParams.forEach((value, key) => {
                    const input = filterForm.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = value;
                        // If this is a course type select, populate courses
                        if (key === 'course_type' && value) {
                            populateCourses(value);
                        }
                        // If country is set, load its states
                        if (key === 'country_id' && value) {
                            loadStates(value, urlParams.get('state_id'));
                        }
                    }
                });
                
                // Trigger form submission after a short delay to allow states/cities to load
                setTimeout(() => {
                    filterForm.dispatchEvent(new Event('submit'));
                }, 500);
            }
        });

        // Handle university detail links
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.view-details');
            if (target) {
                e.preventDefault();
                const univId = target.getAttribute('data-univ-id');
                let univSlug = target.getAttribute('data-univ-slug');
                
                // If no slug is provided, use the ID as a fallback
                if (!univSlug || univSlug === '') {
                    univSlug = univId;
                }
                
                // Create a clean URL-friendly slug
                const cleanSlug = univSlug.toString()
                    .toLowerCase()
                    .replace(/\s+/g, '-')     // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/\-\-+/g, '-')    // Replace multiple - with single -
                    .replace(/^-+/, '')        // Trim - from start of text
                    .replace(/-+$/, '');        // Trim - from end of text
                
                console.log('Navigating to university:', {
                    id: univId,
                    originalSlug: univSlug,
                    cleanSlug: cleanSlug,
                    url: `/university/${cleanSlug}`
                });
                
                // Navigate to the university page
                window.location.href = `/university/${cleanSlug}`;
            }
        });
      </script>
    @endpush
@endsection
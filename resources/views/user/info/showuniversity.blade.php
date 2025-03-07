@php
    $page_title = 'University List';
    $current_state = Request::segment(2);
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
                        <form id="universityFilterForm" class="row g-2">
                            <!-- University Category Dropdown -->
                            <div class="col-md-2 col-12">
                                <label for="univCategory" class="form-label">University Category</label>
                                <select class="form-select" id="univCategory" name="univ_category">
                                    <option value="">Select Category</option>
                                    <option value="Central University">Central University</option>
                                    <option value="State University">State University</option>
                                    <option value="State private university">State private university</option>
                                    <option value="State public university">State public university</option>
                                    <option value="Deemed University">Deemed University</option>
                                    <option value="Autonomous Institude">Autonomous Institude</option>
                                </select>
                            </div>

                            <!-- Course Type Dropdown -->
                            <div class="col-md-2 col-12">
                                <label for="courseType" class="form-label">Course Type</label>
                                <select class="form-select" id="courseType" name="course_type">
                                    <option value="">Select Course Type</option>
                                    <option value="Technical Courses">Technical Courses</option>
                                    <option value="Management Courses">Management Courses</option>
                                    <option value="Medical Courses">Medical Courses</option>
                                    <option value="Traditional Courses">Traditional Courses</option>
                                </select>
                            </div>

                            <!-- Courses Dropdown (Dynamic) -->
                            <div class="col-md-2 col-12">
                                <label for="courses" class="form-label">Courses</label>
                                <select class="form-select" id="courses" name="courses">
                                    <option value="">Select Course</option>
                                    <!-- Options will be populated dynamically via JS -->
                                </select>
                            </div>

                            <!-- University Name Input -->
                            <div class="col-md-2 col-12">
                                <label for="univName" class="form-label">University Name</label>
                                <input type="text" class="form-control" id="univName" name="univ_name" placeholder="Enter university name">
                            </div>

                            <!-- Filter Button -->
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary w-100 mt-4">Filter</button>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="button" class="btn btn-primary w-100 mt-4" id="resetFilterButton">Clear Filter</button>
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
                                @foreach ($matched_state['universities'] as $univ)
                                    <article class="card on-card mb-2 filter-card"
                                        data-courses="{{ implode(',', collect($univ['courses'])->pluck('course_name')->toArray()) }}"
                                        data-category="{{ $univ['univ_category'] ?? '' }}"
                                        data-course-type="{{ $univ['course_type'] ?? '' }}"
                                        data-name="{{ strtolower($univ['univ_name']) }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="img-fluid rounded-1"
                                                    src="{{ asset('images/university/campus/' . $univ['univ_image']) }}"
                                                    alt="{{ $univ['univ_name'] }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="text-box">
                                                    <div class="between">
                                                        <div>
                                                            <h6>
                                                                <a class="blue" href="/{{ $univ['metadata']['url_slug'] }}">
                                                                    {{ $univ['univ_name'] }}
                                                                </a>
                                                            </h6>
                                                            <p><i class="fa-solid fa-location-dot"></i> {{ $univ['univ_address'] }}</p>
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
                                                                <h6>{{ count($univ['courses']) }} Courses</h6>
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
                                @endforeach
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
    const courseTypeSelect = document.getElementById('courseType');
    const coursesSelect = document.getElementById('courses');
    const filterForm = document.getElementById('universityFilterForm');
    const universityCards = document.querySelectorAll('.filter-card');
    const universityList = document.getElementById('universityList');
    const resetFilterButton = document.getElementById('resetFilterButton');
    let initialState = universityList.innerHTML; // Store initial state of university list

    // Define base URL directly in the script using Laravel's url helper
    window.assetBaseUrl = '{{ url("/") }}'; // This will output http://127.0.0.1:8000/

    // Define asset and route functions or URLs
    const asset = (path) => `${window.assetBaseUrl}/images/${path}`; // Use full base URL
    const route = (name, param) => `/download-pdf/${param}`; // Adjust this based on your route setup

    // Get current state from URL (assuming it's segment 2)
    const currentState = '{{ Request::segment(2) }}'; // Blade syntax to get state from URL
    console.log('Current State:', currentState); // Debug log

    // Dynamic population of Courses dropdown based on Course Type
    courseTypeSelect.addEventListener('change', function () {
        const courseType = this.value;
        coursesSelect.innerHTML = '<option value="">Select Course</option>'; // Reset options

        if (courseType) {
            fetch(`/api/universities/${currentState}?course_type=${courseType}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Courses Response:', data);
                    if (data.courses && data.courses.length > 0) {
                        data.courses.forEach(course => {
                            const option = document.createElement('option');
                            option.value = course.course_name;
                            option.textContent = course.course_name;
                            coursesSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching courses:', error));
        }
    });

    // Filter logic on form submission
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        let hasMatches = false;

        fetch('/api/universities/' + (currentState ? currentState : '') + '?' + new URLSearchParams(formData).toString())
            .then(response => response.json())
            .then(data => {
                console.log('Universities Response:', data); // Debug log
                universityList.innerHTML = ''; // Clear current list

                if (data.universities && data.universities.length > 0) {
                    data.universities.forEach(univ => {
                        const univName = univ.univ_name || 'Unknown University';
                        const univUrl = univ.univ_url || '#';
                        const univImage = univ.univ_image || 'default.jpg';
                        const univAddress = univ.univ_address || 'Address not available';
                        const univType = univ.univ_type || 'offline';
                        const courses = univ.courses || [];
                        const courseFee = courses.length > 0 ? courses[0].pivot?.univ_course_fee : 'N/A';

                        const card = `
                            <article class="card on-card mb-2 filter-card"
                                data-courses="${courses.map(course => course.course_name).join(',')}"
                                data-category="${univ.univ_category ?? ''}"
                                data-course-type="${courses.length > 0 ? courses[0].course_type : ''}"
                                data-name="${univName.toLowerCase()}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="img-fluid rounded-1" src="${asset('university/campus/' + univImage)}" alt="${univName}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="text-box">
                                            <div class="between">
                                                <div>
                                                    <h6><a class="blue" href="${univUrl}">${univName}</a></h6>
                                                    <p><i class="fa-solid fa-location-dot"></i> ${univAddress}</p>
                                                </div>
                                                <div class="flex">
                                                    <button class="btn btn-outline-secondary rounded-pill com-btn"><small>Compare</small><i class="fa-regular fa-window-restore"></i></button>
                                                    <button class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-bookmark"></i></button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="between">
                                                <div class="row">
                                                    <div class="col-6"><p>Courses Offered</p><h6>${courses.length} Courses</h6></div>
                                                    <div class="col-6"><p>Tuition Fees</p><h6><i class="fa-solid fa-indian-rupee-sign"></i> Starts From ${courseFee}</h6></div>
                                                    <div class="col-6"><p>Exams Accepted</p><h6>JEE, NEET, +2</h6></div>
                                                    <div class="col-6"><p>Mode</p><h6>${univType === 'online' ? '<i class="fa-solid fa-desktop fa-xs"></i> Online Class' : '<i class="fa-solid fa-school fa-xs"></i> Offline Class'}</h6></div>
                                                </div>
                                                <div class="row p-2">
                                                    <div class="col-sm-12 col-6"><a href="${route('download-pdf', 'prospectus_collegevihar.pdf')}" class="btn btn-outline-danger rounded-pill w-100"><i class="fa-solid fa-download"></i><small>Brochure</small></a></div>
                                                    <div class="col-sm-12 col-6"><a class="btn btn-primary rounded-pill w-100" href="#" data-bs-toggle="modal" data-bs-target="#applyModal"><small>Apply Now</small><i class="fa-solid fa-up-right-from-square fa-xs"></i></a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        `;
                        universityList.innerHTML += card;
                    });
                    hasMatches = true;
                }

                if (!hasMatches) {
                    universityList.innerHTML = `
                        <div class="text-center p-4">
                            <p>Nothing Found</p>
                            <button class="btn btn-secondary mt-2" id="backButton">Back</button>
                        </div>
                    `;
                    document.getElementById('backButton').addEventListener('click', function () {
                        universityList.innerHTML = initialState;
                        filterForm.reset();
                        universityCards.forEach(card => card.style.display = 'block');
                    });
                }
            })
            .catch(error => console.error('Error fetching universities:', error));
    });

    // Reset Filter logic
    resetFilterButton.addEventListener('click', function () {
        filterForm.reset();
        coursesSelect.innerHTML = '<option value="">Select Course</option>';
        universityList.innerHTML = initialState;
        universityCards.forEach(card => card.style.display = 'block');
    });

    // Existing Filter by Course logic (unchanged)
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            universityCards.forEach(card => {
                const courses = card.getAttribute('data-courses').split(',');
                if (filter === 'all' || courses.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
  </script>
@endpush
@endsection
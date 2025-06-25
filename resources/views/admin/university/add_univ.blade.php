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
                        <label for="">University Country</label>
                        <input type="text" placeholder="Country" name="univ_country" required>
                        @error('univ_country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="">University State</label>
                        <select required name="univ_state">
                            <option value="" disabled selected>Please Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state['id'] }}">{{ $state['state_name'] }}</option>
                            @endforeach
                        </select>
                        @error('univ_state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="">University City</label>
                        <input type="text" placeholder="City" name="univ_city" required>
                        @error('univ_city')
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

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to all search inputs
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
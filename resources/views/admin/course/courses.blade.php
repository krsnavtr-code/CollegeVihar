@php
$permissions = Request::get('admin_permissions');
@endphp

@extends('admin.components.layout')

@push('styles')
<style>
    .badge-category {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
    }
    .badge-online {
        background-color: #198754;
    }
    .badge-offline {
        background-color: #0d6efd;
    }
    .course-actions {
        white-space: nowrap;
    }
    .course-actions .btn {
        margin: 0 2px;
    }
    .search-box {
        max-width: 300px;
        margin-bottom: 1rem;
    }
    .filter-badges {
        margin-bottom: 1rem;
    }
    .filter-badge {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
    }
    .table-sm-custom td,
    .table-sm-custom th {
        padding: 0.3rem 0.5rem; /* chhoti padding for compact look */
        font-size: 0.50rem; /* optional: chhoti font size */
    }
</style>
@endpush

@section('main')
<main class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Course Management (View Courses)</h1>
            <a href="{{ route('admin.course.add.form') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Course
            </a>
        </div>
        
        <!-- Search and Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="categoryFilter" class="form-select">
                            <option value="">All Categories</option>
                            <option value="UG">Undergraduate (UG)</option>
                            <option value="PG">Postgraduate (PG)</option>
                            <option value="DIPLOMA">Diploma</option>
                            <option value="CERTIFICATION">Certification</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="subcategoryFilter" class="form-select">
                            <option value="">All Subcategories</option>
                            <option value="TECHNICAL">Technical</option>
                            <option value="MANAGEMENT">Management</option>
                            <option value="MEDICAL">Medical</option>
                            <option value="TRADITIONAL">Traditional</option>
                        </select>
                    </div>
                </div>
                
                <!-- Active Filters -->
                <div class="filter-badges mt-2" id="activeFilters">
                    <!-- Active filters will be added here dynamically -->
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm-custom table-responsive align-middle" id="coursesTable">
                        <thead class="table-light">
                            <tr style="font-size: 0.7rem;">
                                <th width="60" class="text-center">#</th>
                                <th>Course Name</th>
                                <th>Short Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Type</th>
                                <th>Create Date</th>
                                <th class="text-center">Status</th>
                                <th>Details</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.7rem; ">
                            @forelse ($courses as $i => $course)
                            <tr data-category="{{ $course['course_category'] }}" 
                                data-subcategory="{{ $course['course_subcategory'] }}"
                                data-status="{{ $course['course_status'] ? 'active' : 'inactive' }}"
                                class="course-row {{ !$course['course_status'] ? 'table-secondary' : '' }}">
                                <td class="text-center">
                                    {{ $courses->firstItem() + $loop->index }}
                                    @if (!$course['course_detail_added'] && $course['course_status'])
                                    <i class="fas fa-exclamation-triangle text-warning ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Course details not added"></i>
                                    @endif
                                    @if (!$course['course_status'])
                                    <i class="fas fa-ban text-danger ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Course is inactive"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold">{{ $course['course_name'] }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted small">{{ $course['course_short_name'] }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary text-white">
                                        {{ $course['course_category'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary text-white">
                                        {{ $course['course_subcategory'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $course['course_online'] ? 'bg-success' : 'bg-primary' }}">
                                        {{ $course['course_online'] ? 'Online' : 'Offline' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $course['created_at']}}
                                </td>
                                <td>
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input course-status-toggle" 
                                               type="checkbox" 
                                               role="switch" 
                                               data-course-id="{{ $course['id'] }}"
                                               {{ $course['course_status'] ? 'checked' : '' }}
                                               id="statusToggle{{ $course['id'] }}">
                                        <label class="form-check-label rounded px-2 ms-2" for="statusToggle{{ $course['id'] }}">
                                            {{ $course['course_status'] ? 'Active' : 'Inactive' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/course/university/{{ $course['id'] }}" 
                                       class="btn btn-sm btn-outline-primary" style="width: 80px;">
                                        <i class="fas fa-school me-1"></i> {{ count($course['universities'] ?? []) }}
                                    </a>
                                </td>
                                <td class="text-end course-actions">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/course/edit/{{ $course['id'] }}" 
                                           class="btn btn-sm btn-light" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Course">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if ((in_array(16, $permissions) || $permissions[0] == '*') && !$course['course_detail_added'])
                                        <a href="/admin/course/add/details/{{ $course['id'] }}"
                                           class="btn btn-sm btn-light"
                                           data-bs-toggle="tooltip"
                                           title="Add Course Details">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        @endif

                                        @if ($permissions && (in_array(19, $permissions) || $permissions[0] == '*') && $course['course_detail_added'])
                                        <a href="/admin/course/edit/details/{{ $course['id'] }}" 
                                           class="btn btn-sm btn-light"
                                           data-bs-toggle="tooltip"
                                           title="Edit Course Details">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        @endif

                                        @if ((in_array(18, $permissions) || $permissions[0] == '*') && $course['course_detail_added'])
                                        <a href="/admin/web_pages/edit/{{ $course['course_slug'] }}"
                                           class="btn btn-sm btn-light"
                                           data-bs-toggle="tooltip"
                                           title="Edit SEO">
                                            <i class="fas fa-search"></i>
                                        </a>
                                        @endif

                                        @if (in_array(20, $permissions) || $permissions[0] == '*')
                                        <form action="{{ route('admin.course.delete', $course['id']) }}" method="POST" class="d-inline" id="delete-form-{{ $course['id'] }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-light text-danger delete-course"
                                                    data-course-id="{{ $course['id'] }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete Course">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">No courses found. <a href="{{ route('admin.course.add.form') }}">Add a new course</a> to get started.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($courses->hasPages())
                <div class="card-footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-muted small mb-2 mb-md-0">
                            Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} entries
                        </div>
                        <nav aria-label="Course pagination">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($courses->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $courses->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                                    @if ($page == $courses->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($courses->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $courses->nextPageUrl() }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Filter elements
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const subcategoryFilter = document.getElementById('subcategoryFilter');
        const activeFilters = document.getElementById('activeFilters');
        const courseRows = document.querySelectorAll('.course-row');

        // Function to update active filters display
        function updateActiveFilters() {
            activeFilters.innerHTML = '';
            const filters = [];
            
            if (categoryFilter.value) {
                filters.push({
                    type: 'category',
                    value: categoryFilter.value,
                    text: 'Category: ' + categoryFilter.options[categoryFilter.selectedIndex].text
                });
            }
            
            if (subcategoryFilter.value) {
                filters.push({
                    type: 'subcategory',
                    value: subcategoryFilter.value,
                    text: 'Subcategory: ' + subcategoryFilter.options[subcategoryFilter.selectedIndex].text
                });
            }
            
            filters.forEach(filter => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary me-2 mb-2 d-inline-flex align-items-center';
                badge.innerHTML = `
                    ${filter.text}
                    <button type="button" class="btn-close btn-close-white ms-2" aria-label="Remove filter" 
                            data-filter-type="${filter.type}" style="font-size: 0.5rem;"></button>
                `;
                activeFilters.appendChild(badge);
            });
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.btn-close').forEach(btn => {
                btn.addEventListener('click', function() {
                    const filterType = this.getAttribute('data-filter-type');
                    if (filterType === 'category') {
                        categoryFilter.value = '';
                    } else if (filterType === 'subcategory') {
                        subcategoryFilter.value = '';
                    }
                    filterCourses();
                });
            });
        }

        // Function to filter courses
        function filterCourses() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;
            const subcategory = subcategoryFilter.value;
            
            courseRows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const rowCategory = row.getAttribute('data-category');
                const rowSubcategory = row.getAttribute('data-subcategory');
                
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !category || rowCategory === category;
                const matchesSubcategory = !subcategory || rowSubcategory === subcategory;
                
                if (matchesSearch && matchesCategory && matchesSubcategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateActiveFilters();
        }

        // Event listeners
        searchInput.addEventListener('input', filterCourses);
        categoryFilter.addEventListener('change', filterCourses);
        subcategoryFilter.addEventListener('change', filterCourses);
        
        // Initialize filters from URL parameters if present
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('category')) {
            categoryFilter.value = urlParams.get('category');
        }
        if (urlParams.has('subcategory')) {
            subcategoryFilter.value = urlParams.get('subcategory');
        }
        if (urlParams.has('search')) {
            searchInput.value = urlParams.get('search');
        }
        
        // Initial filter
        filterCourses();
    });

    // Handle course deletion
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-course')) {
            const button = e.target.closest('.delete-course');
            const courseId = button.getAttribute('data-course-id');
            const form = document.getElementById(`delete-form-${courseId}`);
            const courseName = button.closest('tr').querySelector('td:nth-child(2)').textContent.trim();
            
            if (confirm(`Are you sure you want to delete the course "${courseName}"? This action cannot be undone.`)) {
                // Show loading state
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
                
                // Send the request
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE',
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Course deleted successfully');
                        } else {
                            alert(data.message || 'Course deleted successfully');
                        }
                        // Remove the row from the table
                        const row = button.closest('tr');
                        row.style.opacity = '0.5';
                        setTimeout(() => {
                            row.remove();
                            // Check if table is empty
                            if (document.querySelectorAll('#coursesTable tbody tr:not(.no-data)').length === 0) {
                                const tbody = document.querySelector('#coursesTable tbody');
                                tbody.innerHTML = `
                                    <tr class="no-data">
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-muted">No courses found. <a href="{{ route('admin.course.add.form') }}">Add a new course</a> to get started.</div>
                                        </td>
                                    </tr>`;
                            }
                        }, 300);
                    } else {
                        // Show error with lead details if available
                        let errorMessage = data.message || 'Failed to delete course';
                        
                        // If we have lead details, format them nicely
                        if (data.leads && data.leads.length > 0) {
                            errorMessage += '\n\nAssociated Leads:';
                            data.leads.forEach(lead => {
                                errorMessage += `\n• ID: ${lead.id} - ${lead.name} (${lead.email || 'No Email'})`;
                            });
                        }
                        
                        throw new Error(errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Split the error message by newlines to handle the lead details
                    const errorMessages = error.message.split('\n');
                    
                    if (typeof toastr !== 'undefined') {
                        // Show the first line as the main message
                        toastr.error(errorMessages[0]);
                        // Show additional lines as separate error messages
                        for (let i = 1; i < errorMessages.length; i++) {
                            if (errorMessages[i].trim()) {
                                toastr.error(errorMessages[i].trim(), '', {timeOut: 0, extendedTimeOut: 0, closeButton: true});
                            }
                        }
                    } else {
                        alert(error.message);
                    }
                })
                .finally(() => {
                    // Reset button state
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        }
    });

    // Handle course status toggle via switch
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('course-status-toggle')) {
            const toggle = e.target;
            const courseId = toggle.getAttribute('data-course-id');
            const label = toggle.nextElementSibling;
            const row = toggle.closest('tr');
            const originalState = !toggle.checked; // Store the original state in case of failure
            
            // Show loading state
            toggle.disabled = true;
            
            // Make the API call
            fetch(`admin/course/toggle-status/${courseId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI based on new status
                    if (data.new_status) {
                        // Activated
                        toggle.checked = true;
                        label.textContent = 'Active';
                        row.classList.remove('table-secondary');
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Course activated successfully');
                        }
                    } else {
                        // Deactivated
                        toggle.checked = false;
                        label.textContent = 'Inactive';
                        row.classList.add('table-secondary');
                        if (typeof toastr !== 'undefined') {
                            toastr.warning(data.message || 'Course deactivated and removed from users');
                        }
                    }
                } else {
                    // Revert the toggle if the request failed
                    toggle.checked = originalState;
                    label.textContent = originalState ? 'Active' : 'Inactive';
                    throw new Error(data.message || 'Failed to update course status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message || 'Failed to update course status');
                } else {
                    alert(error.message || 'Failed to update course status');
                }
                // Revert the toggle on error
                toggle.checked = originalState;
                label.textContent = originalState ? 'Active' : 'Inactive';
            })
            .finally(() => {
                toggle.disabled = false;
            });
        }
    });

    // Old status toggle function - keeping for reference
    function switch_status(node, courseId) {
        if (!confirm('Are you sure you want to change the status of this course?')) {
            return;
        }
        
        ajax({
            url: "/admin/course/toggle-status/" + courseId,
            method: 'POST',
            data: {_token: '{{ csrf_token() }}'},
            success: (res) => {
                if (res.success) {
                    const row = node.closest('tr');
                    if (res.new_status) {
                        // Activate
                        row.classList.remove('table-secondary');
                        row.querySelector('.status-badge').className = 'badge bg-success bg-opacity-10 text-success';
                        row.querySelector('.status-badge').textContent = 'Active';
                        node.classList.add('d-none');
                        row.querySelector('.btn-deactivate').classList.remove('d-none');
                        toastr.success('Course activated successfully');
                    } else {
                        // Deactivate
                        row.classList.add('table-secondary');
                        row.querySelector('.status-badge').className = 'badge bg-secondary bg-opacity-10 text-secondary';
                        row.querySelector('.status-badge').textContent = 'Inactive';
                        node.classList.add('d-none');
                        row.querySelector('.btn-activate').classList.remove('d-none');
                        toastr.success('Course deactivated successfully');
                    }
                } else {
                    toastr.error(res.message || 'Failed to update course status');
                }
            },
            error: (err) => {
                console.error('Error:', err);
                toastr.error('An error occurred while updating the course status');
            }
        });
    }

    // Handle course deletion
    function deleteCourse(button) {
        if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
            return;
        }
        
        const courseId = button.getAttribute('data-course-id');
        
        ajax({
            url: "/admin/course/delete/" + courseId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: (res) => {
                if (res.success) {
                    toastr.success(res.message || 'Course deleted successfully');
                    // Fade out and remove the row
                    const row = button.closest('tr');
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                } else {
                    toastr.error(res.message || 'Failed to delete course');
                }
            },
            error: (err) => {
                console.error('Error:', err);
                toastr.error('An error occurred while deleting the course');
            }
        });
    }
</script>
@endpush
@endsection
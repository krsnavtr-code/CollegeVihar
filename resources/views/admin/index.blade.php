@extends('admin.components.layout')

@section('title', 'Dashboard - CV Admin')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stat-card i {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    .activity-item {
        border-left: 3px solid #4e73df;
        padding: 10px 15px;
        margin-bottom: 15px;
        background: #f8f9fa;
        border-radius: 0 8px 8px 0;
    }
    .activity-item .time {
        font-size: 0.75rem;
        color: #6c757d;
    }
    .quick-links .card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,.125);
    }
    .quick-links .card:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    .quick-actions .btn {
        margin: 5px;
        min-width: 120px;
    }
    .system-status .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .status-online { background-color: #1cc88a; }
    .status-warning { background-color: #f6c23e; }
    .status-offline { background-color: #e74a3b; }
    .recent-registrations img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    #calendar {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .notification-item {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    .notification-item:hover { background-color: #f8f9fa; }
    .notification-item.unread { background-color: #f8f9ff; }
    .notification-time {
        font-size: 0.75rem;
        color: #6c757d;
    }
</style>
@endpush

@section('main')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-flex">
            <div class="dropdown me-2">
                <button class="btn btn-primary shadow-sm dropdown-toggle" type="button" id="generateReportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                </button>
                <ul class="dropdown-menu" aria-labelledby="generateReportDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.reports.students') }}">Students Report</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.courses') }}">Courses Report</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.admissions') }}">Admissions Report</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" id="customReportBtn">Custom Report</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body text-center quick-actions">
                    <!-- Student management coming soon -->
                    <a href="{{ route('admin.course.add.form') }}" class="btn btn-success mb-2 mb-md-0">
                        <i class="fas fa-plus-circle me-1"></i> Add Course
                    </a>
                    <a href="{{ url('/admin/university/add') }}" class="btn btn-info text-white mb-2 mb-md-0">
                        <i class="fas fa-university me-1"></i> Add University
                    </a>
                    <a href="{{ url('/admin/leads/add') }}" class="btn btn-warning mb-2 mb-md-0">
                        <i class="fas fa-user-tag me-1"></i> Add Lead
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats and Charts Row -->
    <div class="row mb-4">
        <!-- Enrollment Chart -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Enrollment Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                            <li><a class="dropdown-item" href="#">Custom Range</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Distribution -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Course Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="courseDistributionChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="me-2">
                            <i class="fas fa-circle text-primary"></i> Engineering
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-success"></i> Medical
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-info"></i> Management
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <!-- Total Students -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,250</div>
                            <div class="mt-2 text-xs">
                                <span class="text-success font-weight-bold">
                                    <i class="fas fa-arrow-up"></i> 12%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">85</div>
                            <div class="mt-2 text-xs">
                                <span class="text-success font-weight-bold">
                                    <i class="fas fa-arrow-up"></i> 5%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Universities Count -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Universities</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">120</div>
                            <div class="mt-2 text-xs">
                                <span class="text-success font-weight-bold">
                                    <i class="fas fa-arrow-up"></i> 3%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-university fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            <div class="mt-2 text-xs">
                                <span class="text-danger font-weight-bold">
                                    <i class="fas fa-arrow-down"></i> 2
                                </span>
                                <span class="text-muted">Since yesterday</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">View All</a></li>
                            <li><a class="dropdown-item" href="#">Mark as Read</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">New student registration</h6>
                            <small class="time">10 mins ago</small>
                        </div>
                        <p class="mb-1">John Doe registered for B.Tech in Computer Science</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">New course added</h6>
                            <small class="time">2 hours ago</small>
                        </div>
                        <p class="mb-1">New course "Artificial Intelligence" has been added</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">University updated</h6>
                            <small class="time">1 day ago</small>
                        </div>
                        <p class="mb-1">Information for Delhi Technological University has been updated</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">New lead received</h6>
                            <small class="time">2 days ago</small>
                        </div>
                        <p class="mb-1">New lead received for MBA program</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Calendar -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Calendar</h6>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Status</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush system-status">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="status-indicator status-online"></span>
                                <span>Server Uptime</span>
                            </div>
                            <span class="badge bg-success rounded-pill">99.9%</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="status-indicator status-online"></span>
                                <span>Database</span>
                            </div>
                            <span class="badge bg-success rounded-pill">Online</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="status-indicator status-warning"></span>
                                <span>Storage</span>
                            </div>
                            <span class="badge bg-warning rounded-pill">75% Used</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="status-indicator status-online"></span>
                                <span>Active Users</span>
                            </div>
                            <span class="badge bg-primary rounded-pill">24</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Links</h6>
                    <button class="btn btn-sm btn-link p-0" data-bs-toggle="tooltip" title="Customize">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
                <div class="card-body quick-links">
                    <a href="{{ url('/admin/course') }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-book text-primary me-3"></i>
                                    <span>Manage Courses</span>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/admin/university') }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-university text-success me-3"></i>
                                    <span>Manage Universities</span>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/admin/lead') }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-graduate text-info me-3"></i>
                                    <span>Manage Leads</span>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/admin/employee') }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users-cog text-warning me-3"></i>
                                    <span>Manage Employees</span>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Admin Profile -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Admin Profile</h6>
                </div>
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle mb-3" 
                         src="/images/web assets/logo_mini.jpeg" 
                         alt="Admin" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="mb-1">{{ Request::get('admin_data')['emp_name'] ?? 'Admin' }}</h5>
                    <p class="text-muted mb-3"><i class="fas fa-envelope me-2"></i>{{ Session::get('admin_username') }}</p>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-edit me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample data - Replace with actual data from your application
    const stats = {
        totalStudents: 1250,
        totalCourses: 85,
        totalUniversities: 120,
        pendingRequests: 18
    };

    // Initialize Charts
    initEnrollmentChart();
    initCourseDistributionChart();
    initCalendar();

    // Enrollment Chart
    function initEnrollmentChart() {
        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'New Students',
                    data: [65, 59, 80, 81, 56, 55, 40, 50, 60, 70, 90, 100],
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Enrollment Overview'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Course Distribution Chart
    function initCourseDistributionChart() {
        const ctx = document.getElementById('courseDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Engineering', 'Medical', 'Management', 'Arts', 'Science', 'Law'],
                datasets: [{
                    data: [35, 25, 20, 10, 5, 5],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9',
                        '#17a673',
                        '#2c9faf',
                        '#dda20a',
                        '#be2617',
                        '#6c757d'
                    ],
                    hoverBorderColor: 'rgba(234, 236, 244, 1)',
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 },
                        padding: 12
                    }
                },
                cutout: '70%',
            },
        });
    }

    // Initialize Calendar
    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'Admission Deadline',
                        start: new Date(),
                        end: new Date(),
                        backgroundColor: '#e74a3b',
                        borderColor: '#e74a3b'
                    }
                ]
            });
            calendar.render();
        }
    }

    // Mark notification as read
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            this.classList.remove('unread');
            // Add AJAX call to mark as read in database
        });
    });

    // Quick search functionality
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    // Show alert for now since search route is not implemented
                    alert('Search functionality will be implemented soon. You searched for: ' + query);
                    // Clear the search input
                    this.value = '';
                }
            }
        });
    }

    // Handle export data clicks
    document.querySelectorAll('.export-data').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.dataset.type;
            
            // Map export types to their corresponding routes
            const routeMap = {
                'students': '{{ route("admin.reports.students") }}',
                'courses': '{{ route("admin.reports.courses") }}',
                'admissions': '{{ route("admin.reports.admissions") }}'
            };
            
            const url = routeMap[type];
            
            if (!url) {
                alert('Export type not supported yet');
                return;
            }
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
            
            // Trigger download
            const link = document.createElement('a');
            link.href = url;
            link.download = `${type}_export_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Reset button state
            setTimeout(() => {
                this.innerHTML = originalText;
            }, 2000);
        });
    });

    // Custom Report Button
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'customReportBtn' || e.target.closest('#customReportBtn')) {
            e.preventDefault();
            showCustomReportModal();
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle form submission
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'customReportForm') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';
            
            // Submit form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                // Create a download link and trigger it
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `custom_report_${new Date().toISOString().split('T')[0]}.${formData.get('format')}`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
                
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('customReportModal'));
                if (modal) modal.hide();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating report. Please try again.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        }
    });
});

// Custom Report Modal
function showCustomReportModal() {
    // Check if modal already exists
    if (document.getElementById('customReportModal')) {
        const existingModal = new bootstrap.Modal(document.getElementById('customReportModal'));
        existingModal.show();
        return;
    }
    
    const modalHTML = `
    <div class="modal fade" id="customReportModal" tabindex="-1" aria-labelledby="customReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="customReportModalLabel">Generate Custom Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customReportForm" action="{{ route('admin.reports.custom') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reportType" class="form-label">Report Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="reportType" name="type" required>
                                <option value="">Select report type</option>
                                <option value="students">Students</option>
                                <option value="courses">Courses</option>
                                <option value="enrollments">Enrollments</option>
                                <option value="leads">Leads</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="end_date" max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Format <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv" checked>
                                <label class="form-check-label" for="formatCsv">CSV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="format" id="formatPdf" value="pdf">
                                <label class="form-check-label" for="formatPdf">PDF</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel">
                                <label class="form-check-label" for="formatExcel">Excel</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="generateReportBtn">
                            <i class="fas fa-download me-1"></i> Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Initialize and show modal
    const modalElement = document.getElementById('customReportModal');
    const reportModal = new bootstrap.Modal(modalElement);
    
    // Set up date validation
    const startDateInput = modalElement.querySelector('#startDate');
    const endDateInput = modalElement.querySelector('#endDate');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                this.value = startDateInput.value;
            }
        });
    }
    
    // Remove modal from DOM when hidden
    modalElement.addEventListener('hidden.bs.modal', function() {
        modalElement.remove();
    });
    
    // Show the modal
    reportModal.show();
}
</script>
@endpush
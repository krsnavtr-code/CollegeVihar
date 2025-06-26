<style>
    .admin-navbar {
        z-index: 100;
        padding: 0 1.5rem;
        background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>


<!-- Admin Navbar -->
<nav class="admin-navbar navbar navbar-expand-lg navbar-light border-bottom shadow-sm">
    <div class="container-fluid px-0">
        <!-- Sidebar Toggle Button (Visible on mobile) -->
        <button class="btn btn-link text-white p-0 me-3 d-lg-none" id="mobileSidebarToggle">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        
        <!-- Sidebar Toggle Button (Visible on desktop) -->
        <button class="btn btn-link text-white p-0 me-3 d-none d-lg-block" id="desktopSidebarToggle">
            <i class="fas fa-bars fa-lg"></i>
        </button>

        <!-- Brand/Logo (Visible on all screens) -->
        <a class="navbar-brand me-4" href="{{ route('admin_home') }}">
            <img src="{{ asset('images/web assets/logo_full.jpeg') }}" alt="Logo" height="30" class="d-inline-block align-text-top rounded">
        </a>

        <!-- Search Bar (Visible on large screens) -->
        <div class="d-none d-lg-flex align-items-center justify-content-center flex-grow-1 mx-4">
            <div class="input-group" style="max-width: 250px;">
                <!-- <span class="input-group-text bg-light border-0">
                    <i class="fas fa-search text-muted"></i>
                </span> -->
                <input type="text" id="globalSearch" class="form-control border-0 bg-light m-0" placeholder="Search..." aria-label="Search">
            </div>
        </div>

        <!-- Right Side Navigation -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Notifications Dropdown -->
            <!-- <div class="dropdown me-3 d-none d-md-block">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                    <li class="dropdown-header">Notifications</li>
                    <li><a class="dropdown-item" href="#">New user registered</a></li>
                    <li><a class="dropdown-item" href="#">New message received</a></li>
                    <li><a class="dropdown-item" href="#">System update available</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                </ul>
            </div> -->

            <!-- Messages Dropdown -->
            <!-- <div class="dropdown me-3 d-none d-md-block">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-envelope fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                        5
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown" style="min-width: 300px;">
                    <li class="dropdown-header">Messages</li>
                    <li><a class="dropdown-item" href="#">New message from John</a></li>
                    <li><a class="dropdown-item" href="#">You have 5 unread messages</a></li>
                    <li><a class="dropdown-item" href="#">Meeting reminder</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="#">View all messages</a></li>
                </ul>
            </div> -->

            <!-- User Dropdown -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <div class="me-2 d-none d-md-block text-end">
                        <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin User' }}</div>
                        <div class="small text-muted">Administrator</div>
                    </div> -->
                    <div class="avatar avatar-sm">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=0D8ABC&color=fff' }}" 
                             alt="User" class="rounded-circle" width="40" height="40">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 200px;">
                    <!-- <li>
                        <a class="dropdown-item" href="#" onclick="alert('Profile page coming soon!')">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="alert('Settings page coming soon!')">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li> -->
                    <li>
                        <a class="dropdown-item text-danger" href="#" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Add some padding to the top of the page content to account for the fixed navbar -->
<!-- <div style="height: 70px;"></div> -->

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar toggle
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-show');
            });
        }

        // Close sidebar when clicking on nav items on mobile
        const navItems = document.querySelectorAll('.nav-link');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    document.body.classList.remove('sidebar-show');
                }
            });
        });
    });
</script>
@endpush

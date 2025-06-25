<!DOCTYPE html>
<html lang="en" data-scroll="no-scroll">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CV Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <link rel="stylesheet" href="/css/utils.php">
    <link rel="stylesheet" href="/css/my-admin.css">
    @stack('css')


    <style>
        /* Custom Scrollbar Styles */
        #mainSidebarMenu,
        #mainSidebarMenu > ul.nav {
            scrollbar-width: thin !important;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent !important;
        }
        
        /* For Webkit browsers */
        #mainSidebarMenu::-webkit-scrollbar,
        #mainSidebarMenu > ul.nav::-webkit-scrollbar {
            width: 6px !important;
            height: 6px !important;
        }
        
        #mainSidebarMenu::-webkit-scrollbar-track,
        #mainSidebarMenu > ul.nav::-webkit-scrollbar-track {
            background: transparent !important;
            margin: 8px 0 !important;
        }
        
        #mainSidebarMenu::-webkit-scrollbar-thumb,
        #mainSidebarMenu > ul.nav::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3) !important;
            border-radius: 10px !important;
            border: 2px solid transparent !important;
            background-clip: padding-box !important;
        }
        
        #mainSidebarMenu::-webkit-scrollbar-thumb:hover,
        #mainSidebarMenu > ul.nav::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.5) !important;
        }

        /* ===== Base Styles ===== */
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --primary-bg: #f5f7fa;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --border-color: #eee;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 0 15px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        /* ===== Sidebar Styles ===== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            z-index: 1000;
            transition: var(--transition);
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-logo {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            transition: var(--transition);
        }
        
        /* Sidebar Menu */
        .sidebar-menu {
            flex: 1;
            padding: 0 10px 20px;
            overflow-y: auto;
        }
        
        .nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 4px;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: 500;
        }
        
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #fff;
            border-radius: 0 4px 4px 0;
        }
        
        .nav-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .nav-text {
            flex: 1;
            white-space: nowrap;
            transition: var(--transition);
        }
        
        .nav-arrow {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }
        
        .nav-link[aria-expanded="true"] .nav-arrow {
            transform: rotate(90deg);
        }
        
        /* Submenu */
        .submenu {
            padding: 5px 0 5px 15px;
            list-style: none;
            margin: 0;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }
        
        .collapse.show .submenu {
            max-height: 1000px;
        }
        
        .submenu-item {
            margin: 4px 0;
        }
        
        .submenu-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .submenu-link:hover, .submenu-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding-left: 20px;
        }
        
        .submenu-icon {
            width: 20px;
            margin-right: 10px;
            font-size: 0.8rem;
            display: flex;
            justify-content: center;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-details {
            flex: 1;
            overflow: hidden;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        /* Collapsed State */
        body.sidebar-collapsed .sidebar {
            width: 70px;
            overflow: hidden;
        }
        
        /* Hover State */
        body.sidebar-collapsed .sidebar:hover {
            width: var(--sidebar-width);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            z-index: 1100;
        }
        
        body.sidebar-collapsed .sidebar:hover .logo-text,
        body.sidebar-collapsed .sidebar:hover .nav-text,
        body.sidebar-collapsed .sidebar:hover .nav-arrow,
        body.sidebar-collapsed .sidebar:hover .user-details {
            display: block;
        }
        
        body.sidebar-collapsed .sidebar:hover .nav-link {
            justify-content: flex-start;
            padding: 12px 15px;
        }
        
        body.sidebar-collapsed .sidebar:hover .nav-icon {
            margin-right: 12px;
        }
        
        body.sidebar-collapsed .sidebar:hover .submenu {
            display: block;
        }
        
        body.sidebar-collapsed .logo-text,
        body.sidebar-collapsed .nav-text,
        body.sidebar-collapsed .nav-arrow,
        body.sidebar-collapsed .user-details {
            display: none;
        }
        
        body.sidebar-collapsed .sidebar-header,
        body.sidebar-collapsed .sidebar-footer {
            display: flex;
            justify-content: center;
            padding: 20px 10px;
        }
        
        body.sidebar-collapsed .logo-container {
            justify-content: center;
        }
        
        body.sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }
        
        body.sidebar-collapsed .nav-icon {
            margin: 0;
            font-size: 1.2rem;
        }
        
        body.sidebar-collapsed .submenu {
            display: none;
        }

        /* Sidebar Scrollbar */
        .sidebar-container::-webkit-scrollbar {
            width: 7px;
        }

        .sidebar-container::-webkit-scrollbar-track {
            background: #0C73B8;
            border-radius: 10px;
        }

        .sidebar-container::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #EE4130, #EE4130);
            border-radius: 10px;
        }

        .sidebar-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #EE4130, #EE4130);
        }

        /* Collapsed Sidebar */
        body.sidebar-collapsed .sidebar-container {
            width: var(--sidebar-collapsed-width);
        }

        /* ===== Main Content Area ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--primary-bg);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }
        
        .content-wrapper {
            flex: 1;
            padding: 20px;
        }

        /* Collapsed State */
        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* ===== Admin Navbar ===== */
        .admin-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* ===== Content Components ===== */
        .content-card {
            background: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow-md);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .page-header h1 {
            font-size: 1.75rem;
            margin: 0;
            color: var(--text-dark);
        }

        /* ===== Overlay ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 799;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===== Responsive Styles ===== */
        @media (max-width: 991.98px) {
            .sidebar-container {
                transform: translateX(-100%);
                z-index: 801;
            }

            .sidebar-container.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                width: 100%;
            }
            
            .admin-navbar {
                position: relative;
                z-index: 1000;
            }
            
            .content-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay"></div>

    <!-- Main Content Wrapper -->
    <div class="main-content">
        <!-- Admin Navbar inside main content -->
        @include('admin.components.admin_navbar')
        
        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('main')
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar-container">
        @include('admin.components.sidebar')
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS, then utils.js, then page scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/utils.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            let hoverTimeout;
            let isHovering = false;
            
            // Toggle sidebar function for desktop
            function toggleDesktopSidebar() {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
                
                // Update toggle button icon
                const icon = desktopToggle ? desktopToggle.querySelector('i') : null;
                if (icon) {
                    icon.className = document.body.classList.contains('sidebar-collapsed') ? 'fas fa-bars fa-lg' : 'fas fa-times fa-lg';
                }
            }
            
            // Toggle sidebar function for mobile
            function toggleMobileSidebar() {
                document.body.classList.toggle('sidebar-show');
                if (document.body.classList.contains('sidebar-show')) {
                    document.body.style.overflow = 'hidden';
                    if (overlay) overlay.classList.add('show');
                } else {
                    document.body.style.overflow = '';
                    if (overlay) overlay.classList.remove('show');
                }
            }
            
            // Close sidebar when clicking on overlay
            function closeSidebar() {
                document.body.classList.remove('sidebar-show');
                document.body.style.overflow = '';
                if (overlay) overlay.classList.remove('show');
            }
            
            // Handle sidebar hover
            function handleSidebarHover(e) {
                if (window.innerWidth <= 991.98) return;
                
                clearTimeout(hoverTimeout);
                
                if (e.type === 'mouseenter') {
                    isHovering = true;
                    if (document.body.classList.contains('sidebar-collapsed')) {
                        document.body.classList.add('sidebar-hover');
                    }
                } else {
                    isHovering = false;
                    hoverTimeout = setTimeout(() => {
                        if (!isHovering && document.body.classList.contains('sidebar-hover')) {
                            document.body.classList.remove('sidebar-hover');
                        }
                    }, 300);
                }
            }
            
            // Event listeners
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDesktopSidebar();
                });
            }
            
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleMobileSidebar();
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', function() {
                    document.body.classList.remove('sidebar-show');
                    document.body.style.overflow = '';
                    overlay.classList.remove('show');
                });
            }
            
            // Add hover event listeners for desktop
            if (sidebar) {
                sidebar.addEventListener('mouseenter', handleSidebarHover);
                sidebar.addEventListener('mouseleave', handleSidebarHover);
            }
            
            // Close mobile sidebar when clicking on nav items
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 991.98) {
                        closeSidebar();
                    }
                });
            });
            
            // Initialize sidebar state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.body.classList.add('sidebar-collapsed');
                // Update toggle button icon if it exists
                const icon = desktopToggle ? desktopToggle.querySelector('i') : null;
                if (icon) {
                    icon.className = 'fas fa-bars fa-lg';
                }
            }
            
            // Handle window resize
            let resizeTimer;
            function handleResize() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (window.innerWidth > 991.98) {
                        // Desktop view
                        document.body.classList.remove('sidebar-show', 'sidebar-hover');
                        if (overlay) {
                            overlay.classList.remove('show');
                        }
                        document.body.style.overflow = '';
                        
                        // Ensure sidebar is visible on desktop when resizing from mobile
                        if (sidebar && !sidebar.classList.contains('show')) {
                            sidebar.classList.add('show');
                        }
                    } else {
                        // Mobile view
                        document.body.classList.remove('sidebar-hover');
                    }
                }, 250);
            }
            
            // Initial check on load
            handleResize();
            
            // Handle future resizes
            window.addEventListener('resize', handleResize);

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Search functionality
            const searchInput = document.querySelector('.sidebar-search input');
            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const menuItems = document.querySelectorAll('.sidebar-menu .nav-item');

                    menuItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @stack('script')
</body>

</html>
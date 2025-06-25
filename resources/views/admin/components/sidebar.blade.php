@php
// Getting all Admin Pages
$pagegroups = App\Models\Adminpagegroup::with('adminpages')
    ->orderBy('group_index', 'asc')
    ->get()
    ->toArray();
$permissions = Request::get('admin_permissions');
@endphp

<!-- Sidebar Container -->
<aside class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo-container">
            <!-- <img src="{{ asset('images/web assets/logo_full.jpeg') }}" alt="Logo" class="sidebar-logo"> -->
            <span class="logo-text">CollegeVihar</span>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav id="mainSidebarMenu" class="sidebar-menu">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin_home') }}">
                    <span class="nav-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </li>

            <!-- Send Email -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/email*') ? 'active' : '' }}" href="{{ route('admin.email') }}">
                    <span class="nav-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <span class="nav-text">Send Email</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </li>

            <!-- Dynamic Menu Groups -->
            @foreach ($pagegroups as $pagegroupIndex => $pagegroup)
                @php
                    $hasActiveChild = false;
                    $menuItems = [];
                    
                    foreach ($pagegroup['adminpages'] as $page) {
                        if ($page['can_display'] && $page['admin_page_status'] && 
                            ($permissions && ($permissions[0] == '*' || in_array($page['id'], $permissions)))) {
                            $isActive = Request::is('admin/' . $page['admin_page_url'] . '*');
                            if ($isActive) $hasActiveChild = true;
                            $menuItems[] = [
                                'title' => $page['admin_page_title'],
                                'url' => $page['admin_page_url'],
                                'is_active' => $isActive,
                                'icon' => $page['icon'] ?? 'fa-circle'
                            ];
                        }
                    }
                    
                    // Skip if no valid menu items
                    if (empty($menuItems)) {
                        continue;
                    }
                @endphp

                @if (count($menuItems) > 0)
                    @php
                        // Default images mapping based on group title
                        $groupImages = [
                            'dashboard' => 'images/sidebar_icons/admin-icon-png.webp',
                            'course' => 'images/sidebar_icons/manage-course-icon.webp',
                            'employee' => 'images/sidebar_icons/manage-emp-icon.png',
                            'exam' => 'images/sidebar_icons/manage-exam-icon.png',
                            'franchise' => 'images/sidebar_icons/manage-franchise-icon.png',
                            'lead' => 'images/sidebar_icons/manage-leads-icon.png',
                            'seo' => 'images/sidebar_icons/manage-seo-icon.png',
                            'university' => 'images/sidebar_icons/manage-univ-icon.png',
                            // Fallback icons for common terms
                            'manage' => 'images/sidebar_icons/admin-icon-png.webp',
                            'admin' => 'images/sidebar_icons/admin-icon-png.webp',
                            'user' => 'images/sidebar_icons/manage-emp-icon.png',
                            'student' => 'images/sidebar_icons/manage-leads-icon.png',
                        ];
                        
                        // Convert group title to lowercase and check for matches
                        $groupTitle = strtolower($pagegroup['group_title']);
                        $defaultImage = 'images/sidebar_icons/admin-icon-png.webp';
                        $imagePath = $defaultImage;
                        
                        foreach ($groupImages as $key => $value) {
                            if (str_contains($groupTitle, $key)) {
                                $imagePath = $value;
                                break;
                            }
                        }
                        
                        // Use the image from database if available, otherwise use the matched default image
                        $groupImage = $pagegroup['icon'] ?? $imagePath;
                        $isImage = filter_var($groupImage, FILTER_VALIDATE_URL) || 
                                  (str_ends_with(strtolower($groupImage), '.png') || 
                                   str_ends_with(strtolower($groupImage), '.jpg') ||
                                   str_ends_with(strtolower($groupImage), '.jpeg') ||
                                   str_ends_with(strtolower($groupImage), '.svg') ||
                                   str_ends_with(strtolower($groupImage), '.gif') ||
                                   str_ends_with(strtolower($groupImage), '.webp'));
                    @endphp
                    
                    <li class="nav-item menu-group {{ $hasActiveChild ? 'active' : '' }}">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#menuGroup{{ $pagegroupIndex }}" 
                           aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}">
                            <span class="nav-icon">
                                @if($isImage)
                                    <img src="{{ asset($groupImage) }}" alt="{{ $pagegroup['group_title'] }}" style="width: 36px; height: 36px; object-fit: contain;">
                                @else
                                    <i class="fas {{ $groupImage }}"></i>
                                @endif
                            </span>
                            <span class="nav-text">{{ $pagegroup['group_title'] }}</span>
                            <span class="nav-arrow">
                                <i class="fas fa-chevron-{{ $hasActiveChild ? 'down' : 'right' }}"></i>
                            </span>
                        </a>
                        <div class="collapse {{ $hasActiveChild ? 'show' : '' }}" id="menuGroup{{ $pagegroupIndex }}">
                            <ul class="submenu">
                                @foreach($menuItems as $menuItem)
                                    <li class="submenu-item">
                                        <a class="submenu-link {{ $menuItem['is_active'] ? 'active' : '' }}" 
                                           href="{{ url('admin/' . $menuItem['url']) }}">
                                            <span class="submenu-icon">
                                                <i class="fas {{ $menuItem['icon'] ?? 'fa-circle' }}"></i>
                                            </span> 
                                            <span class="submenu-text">{{ $menuItem['title'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</aside>

<!-- Overlay for mobile -->
<div class="sidebar-overlay"></div>

@push('styles')
<style>
    /* Sidebar Styles */
    .sidebar {
        width: 100%;
        height: 100%;
        background: #fff;
        display: flex;
        flex-direction: column;
    }
    
    .sidebar-search {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .sidebar-search .input-group {
        background: #f8f9fa;
        border-radius: 4px;
        padding: 5px;
    }
    
    .sidebar-search input {
        border: none;
        background: transparent;
        font-size: 0.9rem;
    }
    
    .sidebar-search input:focus {
        box-shadow: none;
        background: #fff;
    }
    
    .sidebar-menu {
        flex: 1;
        overflow-y: auto !important;
        padding: 1rem 0;
        /* Firefox scrollbar */
        scrollbar-width: thin !important;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent !important;
    }
    
    /* For Webkit browsers like Chrome, Safari */
    .sidebar-menu::-webkit-scrollbar {
        width: 6px !important;
        height: 6px !important;
    }
    
    .sidebar-menu::-webkit-scrollbar-track {
        background: transparent !important;
        margin: 8px 0 !important;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2) !important;
        border-radius: 3px !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.4) !important;
    }
    
    .sidebar-menu .nav-link {
        color: #333;
        padding: 10px 15px;
        margin: 2px 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    /* Icon container */
    .sidebar-menu .nav-item .nav-link .nav-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
        position: relative;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    /* Background image styles */
    .sidebar-menu .nav-item .nav-link .nav-icon[style*="background-image"] {
        background-size: 36px 36px;
        background-repeat: no-repeat;
        background-position: center;
        filter: grayscale(1) brightness(1.5);
        opacity: 0.8;
        transition: all 0.25s ease-in-out;
    }
    
    .sidebar-menu .nav-item.active .nav-link .nav-icon[style*="background-image"],
    .sidebar-menu .nav-item .nav-link:hover .nav-icon[style*="background-image"] {
        filter: grayscale(0) brightness(1.5);
        opacity: 1;
    }
    
    /* Font Awesome icon styles */
    .nav-icon .fas {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.75);
        transition: all 0.25s ease-in-out;
    }
    
    /* Hover/Focus states */
    .nav-item:not(.disabled) .nav-link:hover .nav-icon .sidebar-icon-img,
    .nav-item:not(.disabled) .nav-link:focus .nav-icon .sidebar-icon-img,
    .nav-item.active .nav-link .nav-icon .sidebar-icon-img {
        filter: grayscale(0) brightness(1.5);
        opacity: 1;
        transform: scale(1.05);
    }
    
    .nav-item:not(.disabled) .nav-link:hover .nav-icon .fas,
    .nav-item:not(.disabled) .nav-link:focus .nav-icon .fas,
    .nav-item.active .nav-link .nav-icon .fas {
        color: #fff;
        transform: scale(1.1);
    }
    
    /* Active state */
    .nav-item.active .nav-link .nav-icon .sidebar-icon-img {
        filter: grayscale(0) brightness(1.5) drop-shadow(0 0 4px rgba(255, 255, 255, 0.3));
    }
    
    /* Ensure proper spacing for icons in collapsed state */
    .sidebar-collapsed .nav-icon img {
        width: 30px;
        height: 30px;
    }
    
    .sidebar-collapsed .nav-icon .sidebar-icon-img {
        filter: grayscale(1) brightness(1.5);
        opacity: 0.9;
    }
    
    .sidebar-collapsed .nav-item.active .nav-link .nav-icon .sidebar-icon-img {
        filter: grayscale(0) brightness(1.5);
    }
    
    /* Direct child selector for better specificity */
    .nav-item > .nav-link > .nav-icon .fas {
        display: block;
    }
    
    .has-submenu > .nav-link::after {
        content: '\f054';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-left: auto;
        transition: transform 0.3s;
    }
    .submenu {
        padding-left: 35px;
        margin-top: 5px;
    }
    
    .submenu .nav-link {
        padding: 8px 15px;
        font-size: 0.9rem;
    }
    
    /* Collapsed State */
    body.sidebar-collapsed .sidebar-container {
        width: 70px;
    }
    
    body.sidebar-collapsed .menu-text,
    body.sidebar-collapsed .submenu {
        display: none;
    }
    
    body.sidebar-collapsed .nav-link {
        justify-content: center;
        padding: 10px 0;
    }
    
    body.sidebar-collapsed .nav-link i {
        margin-right: 0;
        font-size: 1.2rem;
    }
    
    /* Sidebar Overlay */
    .sidebar-overlay {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 799;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }
    
    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .sidebar-container {
            transform: translateX(-100%);
        }
        
        .sidebar-container.show {
            transform: translateX(0);
        }
        
        .sidebar-overlay.show {
            display: block;
        }
    }
</style>
@endpush

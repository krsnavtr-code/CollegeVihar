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
    <nav class="sidebar-menu">
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
                    <li class="nav-item menu-group {{ $hasActiveChild ? 'active' : '' }}">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#menuGroup{{ $pagegroupIndex }}" 
                           aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}">
                            <span class="nav-icon">
                                <i class="fas {{ $pagegroup['icon'] ?? 'fa-folder' }}"></i>
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
            
            <!-- Sidebar Footer -->
            <!-- <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=0D8ABC&color=fff' }}" 
                             alt="{{ Auth::user()->name ?? 'Admin' }}">
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>
            <li class="nav-item mt-auto">
                <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li> -->
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
        overflow-y: auto;
        padding: 10px 0;
    }
    
    .sidebar-menu .nav-link {
        color: #333;
        padding: 10px 15px;
        margin: 2px 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .sidebar-menu .nav-link:hover,
    .sidebar-menu .nav-link.active {
        background: #e9ecef;
        color: #0d6efd;
    }
    
    .sidebar-menu .nav-link i {
        width: 20px;
        text-align: center;
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

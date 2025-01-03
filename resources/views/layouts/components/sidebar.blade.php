@php
    $menus = [
        (object) [
            "title" => "Dashboard",
            "path" => "dashboard",
            "icon" => "fas fa-tachometer-alt",
        ],
        (object) [
            "title" => "Laporan Persediaan",
            "path" => "laporan",
            "icon" => "fas fa-file-alt",
        ],
    ];
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-white">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link d-flex align-items-center">
        <img src="/images/Logo.png" alt="Logo" class="brand-image">
        <img src="/images/Text.png" alt="Text Logo" class="text-image" >
    </a>

<script>
    $(document).ready(function () {
    // Function to toggle text logo visibility based on sidebar state
    function toggleSidebarLogos() {
        if ($('body').hasClass('sidebar-mini')) {
            // Hide text logo when sidebar is collapsed
            $('.text-image').hide();
            console.log('Sidebar is minimized, hiding text logo');
        } else {
            // Show text logo when sidebar is expanded
            $('.text-image').show();
            console.log('Sidebar is expanded, showing text logo');
        }
    }

    // Run the function on page load
    toggleSidebarLogos();

    // Listen for the sidebar toggle event (when the sidebar is collapsed/expanded)
    $(document).on('collapsed.pushMenu expanded.pushMenu', function () {
        toggleSidebarLogos();
    });
});

</script>

    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3 pb-3 mb-3 d-flex">
            <div class="input-group" data-widget="sidebar-search">
                <input id="search-input" class="form-control form-control-sidebar bg-white sidebar-search-input d-none d-md-block" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar" style="background-color: #0078C8; color: white;">
                        <i class="fas fa-search fa-fw" style="color: white;"></i>
                    </button>
                </div>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($menus as $menu)
                    <li class="nav-item">
                        <a href="{{ $menu->path[0] !== '/' ? '/' . $menu->path : $menu->path }}" 
                           class="nav-link {{ request()->path() === $menu->path ? 'bg-[#0078C8] text-white' : 'bg-white text-gray-800' }} transition duration-300 ease-in-out ">
                            <i class="nav-icon {{ $menu->icon }}"></i>
                            <p>{{ $menu->title }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>


<!-- Ensure jQuery is loaded -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
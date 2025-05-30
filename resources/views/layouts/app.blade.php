<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiSantri PIT')</title>
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Preline UI -->
    <link href="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.min.css" rel="stylesheet">
    <!--alpinejs-->
    <link rel="stylesheet" href="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Custom Styles -->
    @yield('styles')
</head>

<body class="bg-background text-foreground">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Navbar -->
            @include('components.navbar')

            <!-- Page Content -->
            <main id="main-content"
                class="flex-1 overflow-y-auto p-6 pb-4 bg-secondary/20 transition-all duration-300 ease-in-out flex flex-col justify-between">
                <div>
                    @yield('content')
                </div>

                <footer class="mt-6 text-muted-foreground text-sm">
                    Presented by Programmer Division Pondok IT Indonesia.
                </footer>
            </main>


        </div>
    </div>

    <!-- Preline JS -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            let sidebarOpen = true;

            function toggleSidebar() {
                if (sidebarOpen) {
                    // Close sidebar
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-0', 'md:w-0');
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.classList.remove('md:ml-64');
                    mainContent.classList.add('md:ml-0');
                } else {
                    // Open sidebar
                    sidebar.classList.remove('w-0', 'md:w-0');
                    sidebar.classList.add('w-64');
                    sidebar.style.transform = 'translateX(0)';
                    mainContent.classList.remove('md:ml-0');
                }
                sidebarOpen = !sidebarOpen;
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isMobileMenuOpen = false;
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu')

            console.log(mobileMenuToggle)

            function toggleMobileMenu() {
                if (isMobileMenuOpen) {
                    // Open Mobile Menu
                    mobileMenu.classList.remove('fixed')
                    mobileMenu.classList.add('hidden')
                } else {
                    // Close Mobile Menu
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('fixed');
                }
                isMobileMenuOpen = !isMobileMenuOpen
            }
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu)
            }
        });
    </script>
    @yield('scripts')
</body>

</html>

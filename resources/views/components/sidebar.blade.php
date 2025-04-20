<aside id="sidebar"
    class="w-64 hidden md:flex flex-col bg-white border-r border-border transition-all duration-300 ease-in-out transform translate-x-0 overflow-hidden">
    <!-- Logo -->
    <div class="px-4 pt-4 py-2 ">
        <div class="flex items-center justify-center">
            <img src="{{ asset('assets/images/SiSantri-app.png') }}" alt="SiSantri Logo" class="h-[55px] ml-[-15px]">
        </div>
    </div>


    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto pb-4 pt-2">
        <ul class="space-y-1 px-3">
            <x-navigation item-class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg"
                active-class="bg-primary text-primary-foreground" inactive-class="text-foreground hover:bg-gray-100"
                icon-class="w-5 h-5 mr-2.5" />
        </ul>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-border">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50">
                <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

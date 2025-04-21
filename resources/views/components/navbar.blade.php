<header class="bg-white border-b border-border">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Sidebar toggle button (visible on desktop) -->
            <button id="sidebar-toggle" type="button"
                class="hidden md:flex text-gray-500 hover:text-gray-600 focus:outline-none cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary cursor-pointer"
                    id="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Page title (visible on mobile) -->
            <div class="md:hidden">
                <h1 class="text-lg font-semibold text-primary">SiSantri</h1>
            </div>


            <!-- Right side items -->
            <div class="flex items-center">
                <!-- Notifications -->
                <button type="button" class="p-2 text-gray-500 rounded-lg hover:text-gray-600 hover:bg-gray-100">
                    <span class="sr-only">View notifications</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="relative ml-3">
                    <button type="button"
                        class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                        id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                        onclick="document.querySelector('#user-dropdown').classList.toggle('hidden')">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="ml-2 hidden md:block">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1 hidden md:block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="user-dropdown"
                        class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-border ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">Your Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:cursor-pointer"
                                role="menuitem">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div id="mobile-menu" class="hidden md:hidden w-full z-50 top-[66px] bg-white shadow-lg">
        <div class="space-y-1 px-2 pb-3 pt-2">
            @php
                $navigationItems = app(\App\View\Components\Navigation::class)->getNavigationItems();
            @endphp

            @foreach ($navigationItems as $item)
                @php
                    $isActive = request()->routeIs($item['route'] . '*');
                @endphp
                <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ $isActive ? 'bg-primary text-primary-foreground' : 'text-foreground hover:bg-secondary' }}">
                    @if (isset($item['icon']))
                        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            {!! $item['icon'] !!}
                        </svg>
                    @endif
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>

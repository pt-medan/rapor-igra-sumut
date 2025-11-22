<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-600 to-indigo-800 border-b border-indigo-700 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
                        @php
                            $logo = \App\Models\WebsiteSetting::where('key', 'app_logo')->first();
                            $appName = \App\Models\WebsiteSetting::where('key', 'app_name')->first();
                        @endphp
                        @if ($logo?->value)
                            <img src="{{ asset('storage/' . $logo->value) }}" alt="Logo" class="h-9 w-9 rounded-full object-cover">
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        @endif
                        <span class="hidden sm:block text-white font-bold text-lg">{{ $appName?->value ? $appName->value : 'E-Rapor' }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-indigo-700">
                        🏠 {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->role == 'admin_provinsi')
                        <x-nav-link :href="route('admin.provinsi.users.index')" :active="request()->routeIs('admin.provinsi.users.index')" class="text-white hover:bg-indigo-700">
                            👥 {{ __('Manajemen Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin-website.index')" :active="request()->routeIs('admin-website.*')" class="text-white hover:bg-indigo-700">
                            🌐 {{ __('Admin Website') }}
                        </x-nav-link>
                    @endif

                    {{-- Guru Links --}}
                    @if(auth()->user()->role == 'guru')
                        <x-nav-link :href="route('guru.siswa.index')" :active="request()->routeIs('guru.siswa.*')" class="text-white hover:bg-indigo-700">
                            👨‍🎓 {{ __('Kelola Siswa') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guru.rapor.index')" :active="request()->routeIs('guru.rapor.index')" class="text-white hover:bg-indigo-700">
                            📊 {{ __('Semua Rapor') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guru.sekolah.edit')" :active="request()->routeIs('guru.sekolah.edit')" class="text-white hover:bg-indigo-700">
                            🏫 {{ __('Profil Sekolah') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-100 bg-indigo-700 hover:bg-indigo-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>👤 {{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 text-sm text-gray-700 border-b">
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->role == 'guru' ? 'Guru' : 'Admin Provinsi' }}</p>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-50">
                            ⚙️ {{ __('Pengaturan Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="hover:bg-gray-50">
                                🚪 {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-100 hover:text-white hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->role == 'admin_provinsi')
                <x-responsive-nav-link :href="route('admin.provinsi.users.index')" :active="request()->routeIs('admin.provinsi.users.index')">
                    👥 {{ __('Manajemen Pengguna') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role == 'admin_provinsi')
                <x-responsive-nav-link :href="route('admin-website.index')" :active="request()->routeIs('admin-website.*')">
                    🌐 {{ __('Admin Website') }}
                </x-responsive-nav-link>
            @endif

            {{-- Guru Links (Responsive) --}}
            @if(auth()->user()->role == 'guru')
                <x-responsive-nav-link :href="route('guru.siswa.index')" :active="request()->routeIs('guru.siswa.*')">
                    👨‍🎓 {{ __('Kelola Siswa') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guru.rapor.index')" :active="request()->routeIs('guru.rapor.index')">
                    📊 {{ __('Semua Rapor') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guru.sekolah.edit')" :active="request()->routeIs('guru.sekolah.edit')">
                    🏫 {{ __('Profil Sekolah') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-indigo-600">
            <div class="px-4">
                <div class="font-medium text-base text-white">👤 {{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-indigo-100">{{ Auth::user()->role == 'guru' ? 'Guru' : 'Admin Provinsi' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    ⚙️ {{ __('Pengaturan Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

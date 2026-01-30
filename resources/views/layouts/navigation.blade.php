<nav x-data="{ open: false }" class="bg-[#212844] border-b border-[#1a1f33]">

    <!-- Menu Navigasi Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="/images/logo.png" class="h-8 w-auto" alt="Logo">
                    </a>
                </div>

                <!-- Link Navigasi -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->role === 'user')
                            <x-nav-link 
                                :href="route('dashboard.user')" 
                                :active="request()->routeIs('dashboard.user')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Dashboard
                            </x-nav-link>

                        @elseif(Auth::user()->role === 'admin')
                            <x-nav-link 
                                :href="route('dashboard.admin')" 
                                :active="request()->routeIs('dashboard.admin')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Dashboard
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('admin.users.index')" 
                                :active="request()->routeIs('admin.users.*')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Manajemen Pengguna
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('admin.users.trashed')" 
                                :active="request()->routeIs('admin.users.trashed')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Sampah
                            </x-nav-link>

                        @elseif(Auth::user()->role === 'superadmin')
                            <x-nav-link 
                                :href="route('dashboard.superadmin')" 
                                :active="request()->routeIs('dashboard.superadmin')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Dashboard
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('superadmin.users.index')" 
                                :active="request()->routeIs('superadmin.users.*')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Manajemen Pengguna
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('superadmin.users.trashed')" 
                                :active="request()->routeIs('superadmin.users.trashed')"
                                class="text-white font-semibold text-lg hover:bg-[#1a1f3b] px-3 py-1 rounded">
                                Sampah
                            </x-nav-link>
                        @endif
                    @endauth

                    @guest
                        <x-nav-link 
                            :href="route('login')" 
                            :active="request()->routeIs('login')"
                            class="text-gray-200 hover:text-white">
                            Masuk
                        </x-nav-link>

                        @if (Route::has('register'))
                            <x-nav-link 
                                :href="route('register')" 
                                :active="request()->routeIs('register')"
                                class="text-gray-200 hover:text-white">
                                Daftar
                            </x-nav-link>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Dropdown Pengaturan -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-semibold text-white bg-[#212844] hover:bg-[#1a1f3b] px-3 py-1 rounded transition">
                                <!-- Avatar User -->
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                                     alt="Avatar" class="w-8 h-8 rounded-full border-2 border-white object-cover me-2">
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="ms-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#212844] rounded-md shadow-lg ring-1 ring-black ring-opacity-5">

                                <x-dropdown-link 
                                    :href="route('profile.edit')" 
                                    class="block px-4 py-2 !text-white font-semibold hover:bg-[#1a1f3b]">
                                    Profil
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link 
                                        :href="route('logout')" 
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="block px-4 py-2 !text-white font-semibold hover:bg-[#1a1f3b]">
                                        Keluar
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            @guest
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-200 hover:text-white">
                        Masuk
                    </a>
                </div>
            @endguest

            <!-- Menu Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:bg-[#2a3155]">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Responsif -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#212844]">
        @auth
            <div class="pt-4 pb-1 border-t border-[#1a1f33]">
                <div class="px-4 flex items-center space-x-3">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                         alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white object-cover">
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(Auth::user()->role === 'user')
                        <x-responsive-nav-link :href="route('dashboard.user')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Dashboard
                        </x-responsive-nav-link>

                    @elseif(Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('dashboard.admin')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Dashboard
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('admin.users.index')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Manajemen Pengguna
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('admin.users.trashed')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Sampah
                        </x-responsive-nav-link>

                    @elseif(Auth::user()->role === 'superadmin')
                        <x-responsive-nav-link :href="route('dashboard.superadmin')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Dashboard
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('superadmin.users.index')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Manajemen Pengguna
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('superadmin.users.trashed')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Sampah
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                        Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link 
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-4 pb-1 border-t border-[#1a1f33]">
                <div class="px-4 text-gray-300">
                    Belum masuk
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                        Masuk
                    </x-responsive-nav-link>

                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')" class="text-white font-semibold hover:bg-[#1a1f3b]">
                            Daftar
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endguest
    </div>
</nav>

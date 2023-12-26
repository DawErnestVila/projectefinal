<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> --}}
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                            class="block h-9 w-auto fill-current text-gray-800">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Reserves') }}
                    </x-nav-link>

                    @if (auth()->user()->name == 'Professorat')
                        <x-nav-link :href="route('gestionar-alumnes')" :active="request()->routeIs('gestionar-alumnes')">
                            {{ __('Gestionar Alumnes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('historial-reserves')" :active="request()->routeIs('historial-reserves')">
                            {{ __('Historial Reserves') }}
                        </x-nav-link>
                        <x-nav-link :href="route('gestionar-horaris')" :active="request()->routeIs('gestionar-horaris')">
                            {{ __('Gestionar Horaris') }}
                        </x-nav-link>
                        <x-nav-link :href="route('gestionar-tractaments')" :active="request()->routeIs('gestionar-tractaments')">
                            {{ __('Gestionar Tractaments') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            {{-- <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div> --}}
            {{-- ! Aqui hi ha el codi per si no va bé el dropdown per default --}}
            <div class="relative hidden sm:flex sm:items-center sm:ms-6" id="profile-menu">
                <button
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    onclick="toggleProfileMenu()">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <div id="profile-menu-content"
                    class="hidden absolute top-12 left-4 border border-gray-400 bg-white rounded-md">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Log
                            Out</button>
                    </form>
                </div>
            </div>

            <script>
                function toggleProfileMenu() {
                    let menuContent = document.getElementById('profile-menu-content');
                    menuContent.classList.toggle('hidden');
                }

                // Tancar el menú si l'usuari fa clic fora
                window.addEventListener('click', function(event) {
                    let menu = document.getElementById('profile-menu');
                    if (!menu.contains(event.target)) {
                        let menuContent = document.getElementById('profile-menu-content');
                        menuContent.classList.add('hidden');
                    }
                });
            </script>




            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Reserves') }}
            </x-responsive-nav-link>
            @if (auth()->user()->name == 'Professorat')
                <x-responsive-nav-link :href="route('gestionar-alumnes')" :active="request()->routeIs('gestionar-alumnes')">
                    {{ __('Gestionar Alumnes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('historial-reserves')" :active="request()->routeIs('historial-reserves')">
                    {{ __('Historial Reserves') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('gestionar-horaris')" :active="request()->routeIs('gestionar-horaris')">
                    {{ __('Gestionar Horaris') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('gestionar-tractaments')" :active="request()->routeIs('gestionar-tractaments')">
                    {{ __('Gestionar Tractaments') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

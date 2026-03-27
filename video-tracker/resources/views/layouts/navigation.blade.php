<nav x-data="{ open: false }" class="bg-white border-b border-purple-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl flex items-center">
                        <span class="text-indigo-600 font-black tracking-tighter">Video</span>
                        <span class="text-purple-600 font-black tracking-tighter">Tracker</span>
                        <span class="text-lg ml-1">🎮</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="text-gray-600 hover:text-purple-600 active:text-purple-600 font-bold border-purple-500">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('videogames.index')" :active="request()->routeIs('videogames.index')" 
                        class="text-gray-600 hover:text-purple-600 font-bold border-purple-500">
                        {{ __('Mi Biblioteca') }}
                    </x-nav-link>
                    <x-nav-link :href="route('videogames.catalogo')" :active="request()->routeIs('videogames.catalogo')" 
                        class="text-gray-600 hover:text-purple-600 font-bold border-purple-500">
                        {{ __('Catálogo Global') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-purple-100 text-sm leading-4 font-bold rounded-xl text-gray-600 bg-gray-50 hover:bg-white hover:text-purple-600 transition ease-in-out duration-150 shadow-sm">
                            <div class="mr-1 text-purple-600">👤</div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Ajustes de Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-red-600 hover:bg-red-50"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

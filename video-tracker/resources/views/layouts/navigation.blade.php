<nav x-data="{ open: false }" class="bg-slate-900 border-b border-indigo-500/30 shadow-lg shadow-indigo-500/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl">
                        <span class="text-cyan-400 font-black tracking-tighter">Video</span><span class="text-purple-500 font-black tracking-tighter">Tracker</span>
                        <span class="text-sm ml-1">🎮</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-cyan-400 active:text-cyan-400 border-purple-500">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('videogames.index')" :active="request()->routeIs('videogames.index')" class="text-gray-300 hover:text-cyan-400 border-purple-500">
                        {{ __('Mi Biblioteca') }}
                    </x-nav-link>
                    <x-nav-link :href="route('videogames.catalogo')" :active="request()->routeIs('videogames.catalogo')" class="text-gray-300 hover:text-cyan-400 border-purple-500">
                        {{ __('Catálogo Global') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-purple-500/50 text-sm leading-4 font-bold rounded-xl text-cyan-400 bg-slate-800 hover:bg-slate-700 focus:outline-none transition ease-in-out duration-150 shadow-sm shadow-purple-500/20">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1 italic text-purple-500">LVL 1</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-cyan-500/10">
                            {{ __('Ajustes de Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-500/10"
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

<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-slate-400 text-sm mt-2">Loguéate para acceder a tu inventario</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-cyan-400 mb-1">Identificador (Email)</label>
            <input id="email" class="block w-full bg-slate-800 border-slate-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-inner" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-cyan-400 mb-1">Contraseña</label>
            <input id="password" class="block w-full bg-slate-800 border-slate-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-inner" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-800 text-purple-600 focus:ring-purple-500" name="remember">
                <span class="ms-2 text-sm text-slate-400">Recordar sesión</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-500 hover:text-cyan-400 transition" href="{{ route('password.request') }}">
                    ¿Olvidaste tu clave?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black py-3 rounded-xl shadow-lg shadow-purple-500/30 transition-all transform active:scale-95 uppercase tracking-widest text-sm">
                Iniciar Partida (Log In)
            </button>
        </div>

        <div class="text-center mt-6">
            <a class="text-sm text-cyan-400 hover:text-cyan-300 font-bold transition underline decoration-purple-500 underline-offset-4" href="{{ route('register') }}">
                ¿Eres nuevo? Regístrate aquí
            </a>
        </div>
    </form>
</x-guest-layout>

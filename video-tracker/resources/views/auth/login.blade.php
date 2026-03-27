<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-gray-500 text-sm font-medium">Inicia sesión para gestionar tu colección</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Correo Electrónico</label>
            <input id="email" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Contraseña</label>
            <input id="password" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 shadow-sm" name="remember">
                <span class="ms-2 text-sm text-gray-500">Recordar sesión</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-purple-600 hover:text-indigo-700 transition font-medium" href="{{ route('password.request') }}">
                    ¿Olvidaste tu clave?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3 rounded-xl shadow-md shadow-purple-200 transition-all transform active:scale-95 uppercase tracking-widest text-xs">
                Entrar al Sistema
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                ¿Eres nuevo? 
                <a class="text-indigo-600 hover:text-purple-600 font-bold transition underline decoration-purple-300 underline-offset-4" href="{{ route('register') }}">
                    Crea una cuenta aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

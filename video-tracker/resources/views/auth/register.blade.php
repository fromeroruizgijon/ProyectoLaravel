<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-gray-500 text-sm font-medium">Únete a la comunidad de VideoTracker</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Nombre de Usuario</label>
            <input id="name" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Correo Electrónico</label>
            <input id="email" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Contraseña</label>
                <input id="password" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="block font-bold text-xs uppercase tracking-widest text-indigo-600 mb-1">Confirmar</label>
                <input id="password_confirmation" class="block w-full bg-gray-50 border-gray-200 text-gray-800 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-4 flex flex-col items-center gap-4">
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 rounded-xl shadow-md shadow-purple-200 transition-all transform active:scale-95 uppercase tracking-widest text-xs">
                Registrar Cuenta
            </button>

            <a class="text-sm text-gray-500 hover:text-indigo-600 transition" href="{{ route('login') }}">
                ¿Ya tienes cuenta? <span class="font-bold underline decoration-purple-300">Entra aquí</span>
            </a>
        </div>
    </form>
</x-guest-layout>

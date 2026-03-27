<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-800 tracking-tighter uppercase italic">
            Configuración de <span class="text-purple-600">Perfil</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-8 bg-white shadow-xl rounded-[2.5rem] border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-1">Información de la Cuenta</h3>
                    <p class="text-sm text-gray-500 mb-6">Actualiza tu nombre de usuario y dirección de correo electrónico.</p>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 bg-white shadow-xl rounded-[2.5rem] border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-1">Seguridad</h3>
                    <p class="text-sm text-gray-500 mb-6">Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.</p>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 bg-red-50 shadow-xl rounded-[2.5rem] border border-red-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black text-red-600 uppercase tracking-tight mb-1">Zona Peligrosa</h3>
                    <p class="text-sm text-gray-600 mb-6">Una vez que elimines tu cuenta, todos tus datos y biblioteca de juegos se borrarán permanentemente.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

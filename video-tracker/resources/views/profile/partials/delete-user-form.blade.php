<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="italic rounded-xl px-6 py-2"
    >{{ __('Eliminar mi cuenta definitivamente') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 italic uppercase tracking-tighter">
                ¿Estás seguro de que quieres borrar tu cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Introduce tu contraseña para confirmar la baja definitiva. Esta acción no se puede deshacer.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Contraseña" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4 rounded-xl border-gray-200" placeholder="Contraseña" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl italic">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl italic">
                    {{ __('Borrar Todo') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información del Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Actualiza los datos personales de tu cuenta.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombre" value="Nombre" />
            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $user->nombre)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
        </div>

        <div>
            <x-input-label for="paterno" value="Apellido Paterno" />
            <x-text-input id="paterno" name="paterno" type="text" class="mt-1 block w-full" :value="old('paterno', $user->paterno)" required />
            <x-input-error class="mt-2" :messages="$errors->get('paterno')" />
        </div>

        <div>
            <x-input-label for="materno" value="Apellido Materno" />
            <x-text-input id="materno" name="materno" type="text" class="mt-1 block w-full" :value="old('materno', $user->materno)" required />
            <x-input-error class="mt-2" :messages="$errors->get('materno')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Guardado.</p>
            @endif
        </div>
    </form>
</section>

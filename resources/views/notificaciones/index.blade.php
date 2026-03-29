<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🔔 Mis Notificaciones
            </h2>
            <div class="flex gap-2">
                <form action="{{ route('notificaciones.leerTodas') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                        Marcar todas como leídas
                    </button>
                </form>
                <a href="{{ url('/redirect') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                    ⬅ Regresar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @forelse($notificaciones as $notif)
            <div class="flex items-start gap-4 p-4 rounded-lg shadow-sm border transition
                {{ $notif->leida ? 'bg-white border-gray-100' : 'bg-blue-50 border-blue-200' }}">

                {{-- Ícono según tipo --}}
                <div class="flex-shrink-0 mt-1">
                    @if($notif->tipo === 'solicitud_nueva')
                        <span class="text-2xl">💻</span>
                    @elseif($notif->tipo === 'solicitud_estado')
                        <span class="text-2xl">📬</span>
                    @elseif($notif->tipo === 'falla_resuelta')
                        <span class="text-2xl">✅</span>
                    @else
                        <span class="text-2xl">🔔</span>
                    @endif
                </div>

                {{-- Contenido --}}
                <div class="flex-1">
                    <p class="text-sm {{ $notif->leida ? 'text-gray-600' : 'text-gray-900 font-semibold' }}">
                        {{ $notif->mensaje }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $notif->created_at->diffForHumans() }} — {{ $notif->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                {{-- Acción --}}
                @if(!$notif->leida)
                    <form action="{{ route('notificaciones.leer', $notif->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="text-xs text-blue-600 hover:text-blue-800 whitespace-nowrap font-medium">
                            Marcar como leída
                        </button>
                    </form>
                @else
                    <span class="text-xs text-gray-300">Leída</span>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm p-8 text-center text-gray-400">
                No tienes notificaciones.
            </div>
        @endforelse

        <div class="pt-2">
            {{ $notificaciones->links() }}
        </div>

    </div>

</x-app-layout>

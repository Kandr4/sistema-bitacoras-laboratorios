<x-app-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis fallas 
            </h2>
            <div class="flex gap-2">
                <!-- ➕ NUEVO -->
                <a   href="{{ route('profesor.fallas.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Nuevo
                </a>

                <!-- 🔙 REGRESAR -->
                <a  href="/profesor"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                ⬅ Regresar
                </a>
            </div>
         </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

    

        {{-- 📊 TABLA --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">

            {{-- Encabezado --}}
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-700">
                    Historial de fallas
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Laboratorio</th>
                            <th class="px-4 py-3">Equipo</th>
                            <th class="px-4 py-3">Tipo</th>
                            <th class="px-4 py-3">Estado</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($fallas as $falla)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $falla->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                    {{ $falla->laboratorio->nombre ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $falla->equipo->nombre ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm capitalize text-gray-700">
                                    {{ $falla->tipo_falla }}
                                </td>

                                {{-- Estado con colores --}}
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                                        @if($falla->estado == 'pendiente') bg-yellow-500
                                        @elseif($falla->estado == 'en revision') bg-blue-500
                                        @elseif($falla->estado == 'resuelto') bg-green-500
                                        @endif">
                                        {{ ucfirst($falla->estado) }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    No has registrado fallas todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 📄 Paginación --}}
            <div class="p-4 border-t bg-gray-50">
                {{ $fallas->links() }}
            </div>

        </div>

    </div>
</x-app-layout>
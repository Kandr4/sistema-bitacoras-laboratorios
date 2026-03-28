<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Mi Historial de Asistencias
            </h2>
            <a href="/profesor"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Mensajes --}}
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabla de asistencias --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Laboratorio</th>
                        <th class="px-4 py-3">Entrada</th>
                        <th class="px-4 py-3">Salida</th>
                        <th class="px-4 py-3">Permanencia</th>
                        <th class="px-4 py-3">Asignatura</th>
                        <th class="px-4 py-3">Cuatrimestre</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Práctica</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($asistencias as $asistencia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">{{ $asistencia->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->entrada->format('H:i') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->salida ? $asistencia->salida->format('H:i') : '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($asistencia->salida)
                                    @php
                                        $diff = $asistencia->entrada->diff($asistencia->salida);
                                        $permanencia = '';
                                        if ($diff->h > 0) $permanencia .= $diff->h . 'h ';
                                        $permanencia .= $diff->i . 'min';
                                    @endphp
                                    {{ $permanencia }}
                                @else
                                    <span class="text-yellow-600 font-medium">En curso</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->asignatura ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->cuatrimestre ? $asistencia->cuatrimestre . '°' : '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->grupo ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->carrera ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->nombre_practica ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if(!$asistencia->salida)
                                    <form action="{{ route('profesor.asistencias.salida', $asistencia->idasistencia) }}" method="POST"
                                          onsubmit="return confirm('¿Confirmas que deseas registrar tu salida?')">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm whitespace-nowrap">
                                            Marcar Salida
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Completada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-gray-400">
                                No tienes asistencias registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $asistencias->links() }}
            </div>
        </div>

    </div>

</x-app-layout>

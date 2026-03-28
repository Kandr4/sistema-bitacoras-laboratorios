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

        {{-- Tabla de asistencias --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Laboratorio</th>
                        <th class="px-4 py-3">Entrada</th>
                        <th class="px-4 py-3">Salida</th>
                        <th class="px-4 py-3">Asignatura</th>
                        <th class="px-4 py-3">Cuatrimestre</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Práctica</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($asistencias as $asistencia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">{{ $asistencia->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->entrada->format('H:i') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->salida ? $asistencia->salida->format('H:i') : '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->asignatura ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->cuatrimestre ? $asistencia->cuatrimestre . '°' : '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->grupo ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->carrera ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->nombre_practica ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-400">
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

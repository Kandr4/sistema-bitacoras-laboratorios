<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Respaldos de Base de Datos
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes de Estado -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Botón Regresar -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                    ← Regresar al Panel
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- PANEL IZQUIERDO: Generar y Archivos -->
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Generar Nuevo Respaldo</h3>
                    <p class="text-gray-600 mb-4">
                        Esto creará un duplicado exacto de toda la información actual del sistema incluyendo usuarios, solicitudes, mantenimientos, etc.
                    </p>
                    <form action="{{ route('admin.backups.generar') }}" method="POST" class="mb-6">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:bg-blue-700 transition flex justify-center items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Generar `.sql` Ahora
                        </button>
                    </form>

                    <h4 class="font-bold text-gray-700 mt-8 mb-3">Archivos Disponibles</h4>
                    <div class="bg-gray-50 border rounded-lg p-4 max-h-64 overflow-y-auto">
                        @forelse($archivos as $archivo)
                            <div class="flex justify-between items-center py-2 border-b last:border-0">
                                <span class="text-sm font-mono text-gray-600 truncate mr-2">{{ $archivo }}</span>
                                <a href="{{ route('admin.backups.descargar', $archivo) }}" class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded hover:bg-indigo-200 transition whitespace-nowrap">
                                    Descargar
                                </a>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center">No hay respaldos almacenados en el servidor.</p>
                        @endforelse
                    </div>
                </div>

                <!-- PANEL DERECHO: Restaurar -->
                <div class="bg-white shadow-xl rounded-2xl p-6 border-t-4 border-red-500">
                    <h3 class="text-xl font-bold text-red-700 mb-4 border-b pb-2">Restaurar Base de Datos</h3>
                    <div class="bg-red-50 text-red-800 p-4 rounded-lg text-sm mb-6 border border-red-200 shadow-sm">
                        <strong class="block mb-1">¡ADVERTENCIA DE RIESGO CRÍTICO!</strong>
                        Al subir un archivo <code>.sql</code> iniciarás una restauración profunda. Todos los datos actuales serán eliminados y sustituidos irreversiblemente por el archivo subido. Actúa bajo precaución extrema.
                    </div>

                    <form action="{{ route('admin.backups.restaurar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Selecciona archivo (.sql)</label>
                            <input type="file" name="backup_file" accept=".sql" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" onclick="return confirm('¿ESTÁS COMPLETAMENTE SEGURO? Estás a punto de reescribir toda la base de datos.')" class="w-full bg-red-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:bg-red-700 transition flex justify-center items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Iniciar Restauración Crítica
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- REGISTROS HISTÓRICOS (LOG) -->
            <div class="bg-white shadow-xl rounded-2xl p-6 mt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Registro Histórico (Log de Auditoría)</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="p-3 border-b">ID Operación</th>
                                <th class="p-3 border-b">Usuario Responsable</th>
                                <th class="p-3 border-b">Tipo</th>
                                <th class="p-3 border-b">Archivo Tratado</th>
                                <th class="p-3 border-b">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historial as $log)
                                <tr class="border-b last:border-0 hover:bg-gray-50 text-sm">
                                    <td class="p-3 text-gray-500">#{{ $log->id }}</td>
                                    <td class="p-3 font-medium text-gray-800">{{ $log->user->nombre }} {{ $log->user->paterno }}</td>
                                    <td class="p-3">
                                        @if($log->tipo_operacion === 'Respaldo')
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">Respaldo</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-bold">Restauración</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-gray-600 font-mono text-xs">{{ $log->archivo }}</td>
                                    <td class="p-3 text-gray-500">{{ $log->created_at->format('d/M/Y H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500 italic">No se han registrado operaciones de respaldo o restauración aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>

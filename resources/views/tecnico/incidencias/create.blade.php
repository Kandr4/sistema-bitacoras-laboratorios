<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Incidencia
            </h2>

            <a href="{{ route('tecnico.incidencias.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Formulario de Incidencia</h3>

            <form action="{{ route('tecnico.incidencias.store') }}" method="POST" class="space-y-4" id="formIncidencia">
                @csrf

                {{-- Laboratorio --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Laboratorio <span class="text-red-500">*</span></label>
                    <select name="idlab" required class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Seleccione laboratorio</option>
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Usuario involucrado --}}
               <div>
                    <label class="block text-gray-700 font-medium mb-1">Usuario involucrado (opcional)</label>
                    <select id="usuarioSelect" name="idusuario" placeholder="Seleccione usuario" class="border rounded px-3 py-2 w-full">
                        <option value="">Ninguno</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" data-rol="{{ $usuario->rol }}">
                                {{ $usuario->nombre }} {{ $usuario->paterno }} ({{ ucfirst($usuario->rol) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha y hora --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Fecha y hora de la incidencia <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="fechahora" value="{{ now()->format('Y-m-d\TH:i') }}" required class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                {{-- Número de equipo --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Número / ID del equipo (opcional)</label>
                    <input type="text" name="idequipo" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Descripción de la incidencia <span class="text-red-500">*</span></label>
                    <textarea name="descripcion" rows="4" required class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500" placeholder="Describa detalladamente la incidencia"></textarea>
                </div>

                {{-- Solución --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Solución aplicada (opcional)</label>
                    <textarea name="solucion" rows="3" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500" placeholder="Si se aplicó alguna acción correctiva"></textarea>
                </div>

                {{-- Observaciones --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Observaciones adicionales (opcional)</label>
                    <textarea name="observaciones" rows="3" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500" placeholder="Comentarios adicionales"></textarea>
                </div>

                {{-- Firma digital --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Firma digital <span class="text-red-500">*</span></label>
                    <canvas id="firmaCanvas" class="border rounded w-full h-40 bg-white"></canvas>
                    <input type="hidden" name="firmadigital" id="firmaInput">
                    <button type="button" id="limpiarFirma" class="mt-2 px-4 py-1 bg-gray-300 rounded hover:bg-gray-400 transition">Limpiar firma</button>
                </div>

                {{-- Botón enviar --}}
                <div class="mt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition">
                        Registrar incidencia
                    </button>
                </div>

            </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#usuarioSelect', {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Buscar usuario..."
    });
</script>
    {{-- Script para la firma digital --}}
   <script>
        const canvas = document.getElementById('firmaCanvas');
        const ctx = canvas.getContext('2d');
        const firmaInput = document.getElementById('firmaInput');
        let painting = false;

        // Ajustar tamaño del canvas al tamaño real del elemento
        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        canvas.addEventListener('mousedown', () => painting = true);
        canvas.addEventListener('mouseup', () => { painting = false; ctx.beginPath(); });
        canvas.addEventListener('mouseleave', () => { painting = false; ctx.beginPath(); });
        canvas.addEventListener('mousemove', draw);

        function draw(e) {
            if (!painting) return;

            // Obtener posición exacta del cursor relativo al canvas
            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX - rect.left) * (canvas.width / rect.width);
            const y = (e.clientY - rect.top) * (canvas.height / rect.height);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        // Limpiar firma
        document.getElementById('limpiarFirma').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        // Al enviar formulario
        document.getElementById('formIncidencia').addEventListener('submit', function(e) {
            const dataURL = canvas.toDataURL();
            if(dataURL === 'data:,') { // canvas vacío
                alert('Debe firmar antes de registrar la incidencia.');
                e.preventDefault();
                return false;
            }
            firmaInput.value = dataURL;
        });
        </script>
</x-app-layout>
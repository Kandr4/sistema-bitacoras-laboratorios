<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Código QR — {{ $laboratorio->nombre }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-6">

                <!-- Botones superiores -->
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('admin.laboratorios.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                        ← Regresar
                    </a>

                    <form action="{{ route('admin.laboratorios.qr.generar', $laboratorio->idlab) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition"
                            onclick="return confirm('¿Regenerar el código QR? El anterior dejará de funcionar.')">
                            🔄 Regenerar QR
                        </button>
                    </form>
                </div>

                <!-- Mensaje de éxito -->
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Info del laboratorio -->
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">{{ $laboratorio->nombre }}</h3>
                    <p class="text-gray-500">{{ $laboratorio->ubicacion ?? 'Sin ubicación' }}</p>
                </div>

                <!-- QR generado con JavaScript -->
                <div class="flex justify-center mb-6">
                    <div id="qrcode" class="bg-white p-4 rounded-xl shadow-inner border"></div>
                </div>

                <!-- URL del QR (para copiar) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1">URL de escaneo:</label>
                    <div class="flex gap-2">
                        <input type="text" value="{{ $url }}" id="qr-url" readonly
                            class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-sm text-gray-700">
                        <button onclick="copiarURL()"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition text-sm whitespace-nowrap">
                            📋 Copiar
                        </button>
                    </div>
                </div>

                <!-- Botón imprimir -->
                <div class="text-center">
                    <button onclick="window.print()"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg shadow hover:bg-green-700 transition">
                        🖨️ Imprimir QR
                    </button>
                </div>

            </div>

        </div>
    </div>

    <!-- QRCode.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById("qrcode"), {
                text: "{{ $url }}",
                width: 256,
                height: 256,
                colorDark: "#1e293b",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });

        function copiarURL() {
            const input = document.getElementById('qr-url');
            input.select();
            document.execCommand('copy');
            alert('URL copiada al portapapeles');
        }
    </script>

    <!-- Estilos para impresión -->
    <style>
        @media print {
            body * { visibility: hidden; }
            #qrcode, #qrcode * { visibility: visible; }
            #qrcode {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }
        }
    </style>

</x-app-layout>

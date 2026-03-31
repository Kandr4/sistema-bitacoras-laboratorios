<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistorialBackup;
use \Exception;

class BackupController extends Controller
{
    public function index()
    {
        if (!Storage::disk('local')->exists('backups')) {
            Storage::disk('local')->makeDirectory('backups');
        }

        $historial = HistorialBackup::with('user')->orderBy('created_at', 'desc')->get();

        $archivos = Storage::disk('local')->files('backups');
        $archivos = array_map(function ($path) {
            return basename($path);
        }, $archivos);

        return view('admin.backups.index', compact('historial', 'archivos'));
    }

    public function generarRespaldo()
    {
        try {
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/private/backups/' . $filename);

            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            $dbName = config('database.connections.mysql.database');
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port', '3306');

            $passwordStr = empty($dbPass) ? '' : "-p\"{$dbPass}\"";
            $mysqldumpPath = 'C:\Users\rocky\AppData\Local\com.tinyapp.DBngin\Binaries\mysql\8.4.2\bin\mysqldump.exe';
            $command = "\"{$mysqldumpPath}\" --host=\"{$dbHost}\" --port={$dbPort} --user=\"{$dbUser}\" {$passwordStr} \"{$dbName}\" > \"{$path}\"";

            $returnVar = null;
            $output = null;
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                if (file_exists($path)) {
                    unlink($path); // Eliminar si quedo vacío o con error
                }
                throw new Exception("Verifica si mysqldump.exe está instalado y dentro de las variables de entorno PATH del sistema Windows. Código: $returnVar.");
            }

            HistorialBackup::create([
                'user_id' => Auth::id(),
                'tipo_operacion' => 'Respaldo',
                'archivo' => $filename,
            ]);

            return redirect()->back()->with('success', 'El respaldo se generó y guardó correctamente.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Fallo al generar el respaldo: ' . $e->getMessage());
        }
    }

    public function descargarRespaldo($filename)
    {
        $path = storage_path('app/private/backups/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'El archivo no fue encontrado en el servidor.');
    }

    public function restaurarRespaldo(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file',
        ]);

        try {
            $file = $request->file('backup_file');

            if ($file->getClientOriginalExtension() !== 'sql') {
                return redirect()->back()->with('error', 'El archivo subido debe tener obligatoriamente la extensión .sql.');
            }

            $filename = 'restore_temp_' . date('Ymd_His') . '.sql';
            $file->storeAs('backups/temp', $filename, 'local');
            $path = storage_path('app/private/backups/temp/' . $filename);

            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            $dbName = config('database.connections.mysql.database');
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port', '3306');

            $passwordStr = empty($dbPass) ? '' : "-p\"{$dbPass}\"";
            $mysqlPath = 'C:\Users\rocky\AppData\Local\com.tinyapp.DBngin\Binaries\mysql\8.4.2\bin\mysql.exe';
            // Usamos mysql CLI para procesar el dump local
            $command = "\"{$mysqlPath}\" --host=\"{$dbHost}\" --port={$dbPort} --user=\"{$dbUser}\" {$passwordStr} \"{$dbName}\" < \"{$path}\"";

            $returnVar = null;
            $output = null;
            exec($command, $output, $returnVar);

            File::delete($path);

            if ($returnVar !== 0) {
                throw new Exception("Verifica si mysql.exe está accesible globalmente. Código de error devuelto: $returnVar.");
            }

            HistorialBackup::create([
                'user_id' => Auth::id(),
                'tipo_operacion' => 'Restauracion',
                'archivo' => $file->getClientOriginalName(),
            ]);

            return redirect()->back()->with('success', 'La base de datos fue restaurada exitosamente según el archivo SQL importado.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Fallo al restaurar el respaldo: ' . $e->getMessage());
        }
    }
}

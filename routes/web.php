<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\SolicitudSoftwareController;
use App\Models\Laboratorio; 
use App\Http\Controllers\MantenimientoController;  // Add this import
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\AdminIncidenciaController;
use App\Http\Controllers\FallaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\QrAsistenciaController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NotificacionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/redirect');
})->middleware(['auth'])->name('dashboard');

Route::get('/redirect',[RedirectController::class,'index'])->middleware('auth');

// Ruta de escaneo de QR para registro de asistencia
Route::get('/asistencia/registrar/{token}', [QrAsistenciaController::class, 'registrar'])
    ->middleware('auth')
    ->name('asistencia.registrar');

// Rutas de confirmación y datos de práctica
Route::get('/asistencia/confirmar/{idasistencia}', [QrAsistenciaController::class, 'confirmar'])
    ->middleware('auth')
    ->name('asistencia.confirmar');

Route::post('/asistencia/confirmar/{idasistencia}', [QrAsistenciaController::class, 'guardarDatosPractica'])
    ->middleware('auth')
    ->name('asistencia.guardarDatos');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // NOTIFICACIONES (todos los roles)
    Route::get('notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::put('notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.leerTodas');
    Route::put('notificaciones/{id}/leer', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.leer');

    Route::resource('usuarios', UsuarioController::class);

    // CRUD de fallas
    Route::resource('fallas', FallaController::class);
    
    // Ruta para actualizar estado (solo técnicos)
    Route::put('fallas/{falla}/estado', [FallaController::class, 'updateEstado'])->name('fallas.updateEstado');

    // 👨‍🏫 PROFESOR
    Route::prefix('profesor')->name('profesor.')->group(function () {

        Route::get('/solicitudes/create', [SolicitudSoftwareController::class, 'create'])
            ->name('solicitudes.create');

        Route::post('/solicitudes', [SolicitudSoftwareController::class, 'store'])
            ->name('solicitudes.store');

        Route::get('/solicitudes', [SolicitudSoftwareController::class, 'index'])
            ->name('solicitudes.index');
        // FALLAS PROFESOR
        Route::get('fallas', [FallaController::class, 'indexProfesor'])->name('fallas.index');
        Route::get('fallas/create', [FallaController::class, 'create'])->name('fallas.create');
        Route::post('fallas', [FallaController::class, 'store'])->name('fallas.store');

        // ASISTENCIAS PROFESOR (solo lectura + salida)
        Route::get('asistencias', [AsistenciaController::class, 'historialProfesor'])->name('asistencias.index');
        Route::post('asistencias/{id}/salida', [AsistenciaController::class, 'registrarSalida'])->name('asistencias.salida');
        Route::get('asistencias/{id}/salida', [AsistenciaController::class, 'confirmacionSalida'])->name('asistencias.salida.confirmacion');
    });

    // 👨‍💼 ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('laboratorios', LaboratorioController::class);

        Route::get('/solicitudes', [SolicitudSoftwareController::class, 'all'])
            ->name('solicitudes.index');
        Route::get('/solicitudes/{id}/edit', [SolicitudSoftwareController::class, 'edit'])
            ->name('solicitudes.edit');

        Route::put('/solicitudes/{id}', [SolicitudSoftwareController::class, 'update'])
            ->name('solicitudes.update');
        Route::delete('/solicitudes/{id}', [SolicitudSoftwareController::class, 'destroy'])
            ->name('solicitudes.destroy');
        Route::get('/mantenimientos', [MantenimientoController::class, 'adminIndex'])
        ->name('mantenimiento.index');
        // 🔥 SOLICITUDES DE COMPRA (ADMIN)
        Route::get('solicitudesCompra', [SolicitudController::class,'indexAdmin'])->name('solicitudesCompra.index');
        Route::get('solicitudesCompra/{id}', [SolicitudController::class,'showAdmin'])->name('solicitudesCompra.show');
        Route::put('solicitudesCompra/{id}/estado', [SolicitudController::class,'actualizarEstadoAdmin'])->name('solicitudesCompra.actualizarEstado');
           
        Route::get('incidencias', [AdminIncidenciaController::class, 'index'])->name('incidencias.index');
        Route::get('incidencias/{incidencia}/edit', [AdminIncidenciaController::class, 'edit'])->name('incidencias.edit');
        Route::put('incidencias/{incidencia}', [AdminIncidenciaController::class, 'update'])->name('incidencias.update');
        Route::put('incidencias/{incidencia}/inactivar', [AdminIncidenciaController::class, 'inactivar'])->name('incidencias.inactivar');
        Route::resource('equipos',EquipoController::class);

        // QR de laboratorios
        Route::post('laboratorios/{idlab}/qr', [QrAsistenciaController::class, 'generarQr'])
            ->name('laboratorios.qr.generar');
        Route::get('laboratorios/{idlab}/qr', [QrAsistenciaController::class, 'mostrarQr'])
            ->name('laboratorios.qr.ver');

        // ASISTENCIAS ADMIN (gestión completa)
        Route::get('asistencias', [AsistenciaController::class, 'indexAdmin'])->name('asistencias.index');
        Route::get('asistencias/{id}/edit', [AsistenciaController::class, 'editAdmin'])->name('asistencias.edit');
        Route::put('asistencias/{id}', [AsistenciaController::class, 'updateAdmin'])->name('asistencias.update');
        Route::put('asistencias/{id}/inactivar', [AsistenciaController::class, 'inactivarAdmin'])->name('asistencias.inactivar');
    });

    // 🧑‍🔧 TECNICO 🔥 (LO QUE NECESITAS)
    Route::prefix('tecnico')->name('tecnico.')->group(function () {

        Route::get('/solicitudes', [SolicitudSoftwareController::class, 'all'])
            ->name('solicitudes.index');

        Route::get('/mantenimiento/create', [MantenimientoController::class, 'create'])
        ->name('mantenimiento.create');

        Route::post('/mantenimiento', [MantenimientoController::class, 'store'])
            ->name('mantenimiento.store');

        Route::get('/mantenimiento', [MantenimientoController::class, 'index'])
            ->name('mantenimiento.index');
        Route::get('/mantenimiento/{id}/edit', [MantenimientoController::class, 'edit'])
        ->name('mantenimiento.edit');

        Route::put('/mantenimiento/{id}', [MantenimientoController::class, 'update'])
            ->name('mantenimiento.update');
 
        Route::delete('/mantenimiento/{id}', [MantenimientoController::class, 'destroy'])
            ->name('mantenimiento.destroy');
        // 🔥 SOLICITUDES DE COMPRA (TÉCNICO)
        Route::get('/solicitudes-compra/create', [SolicitudController::class, 'create'])
        ->name('solicitudesCompra.create');

        Route::post('/solicitudes-compra', [SolicitudController::class, 'store'])
        ->name('solicitudesCompra.store');

        Route::get('/solicitudes-compra', [SolicitudController::class, 'index'])
        ->name('solicitudesCompra.index');
        Route::get('/solicitudes-compra/{id}', [SolicitudController::class, 'show'])
        ->name('solicitudesCompra.show');
            
        Route::get('incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
        Route::get('incidencias/create', [IncidenciaController::class, 'create'])->name('incidencias.create');
        Route::post('incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');

        Route::get('incidencias/{incidencia}', [IncidenciaController::class,'show'])->name('incidencias.show');
        Route::put('incidencias/{incidencia}', [IncidenciaController::class,'update'])->name('incidencias.update');
        Route::resource('incidencias', App\Http\Controllers\IncidenciaController::class);
         // CRUD de fallas
        Route::get('fallas', [FallaController::class, 'index'])->name('fallas.index');       // ver fallas
        Route::get('fallas/create', [FallaController::class, 'create'])->name('fallas.create'); // formulario para crear
        Route::post('fallas', [FallaController::class, 'store'])->name('fallas.store');      // guardar falla
        Route::get('fallas/{falla}', [FallaController::class, 'show'])->name('fallas.show'); // ver detalle de falla
        Route::put('fallas/{falla}', [FallaController::class, 'update'])->name('fallas.update'); // actualizar falla

        // ASISTENCIAS TÉCNICO (solo lectura con filtros)
        Route::get('asistencias', [AsistenciaController::class, 'indexTecnico'])->name('asistencias.index');
        
    });  
    

});


Route::get('/admin', function () {
    $laboratorios = Laboratorio::all();

    return view('admin.dashboard', compact('laboratorios'));
})->middleware('auth');

Route::get('/usuarios',[UsuarioController::class,'index'])->middleware('auth');
Route::resource('usuarios', UsuarioController::class);

Route::get('/profesor', function () {
    return view('profesor.dashboard');
})->middleware('auth');

Route::get('/tecnico', function () {
    return view('tecnico.dashboard');
})->middleware('auth');

require __DIR__.'/auth.php';

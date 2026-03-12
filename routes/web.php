<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::resource('usuarios', UsuarioController::class);
});
Route::get('/redirect',[RedirectController::class,'index'])->middleware('auth');


Route::get('/admin', function () {
    return view('admin.dashboard');
    Route::resource('usuarios', UsuarioController::class);
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

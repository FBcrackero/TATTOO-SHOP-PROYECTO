<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

// Enviar enlace de restablecimiento
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

// Mostrar formulario para cambiar la contraseña
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

// Guardar la nueva contraseña
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/departamentos/{pais_id}', [RegisteredUserController::class, 'getDepartamentos']);
Route::get('/ciudades/{departamento_id}', [RegisteredUserController::class, 'getCiudades']);

Route::get('/servicios/ingresar', [ServicioController::class, 'create'])->middleware('auth')->name('servicios.ingresar');
Route::post('/servicios', [ServicioController::class, 'store'])->middleware('auth')->name('servicios.store');
Route::get('/servicios/modificar', [ServicioController::class, 'modificar'])->middleware('auth')->name('servicios.modificar');
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->middleware('auth')->name('servicios.update');
Route::get('/servicios/eliminar', [ServicioController::class, 'eliminar'])->middleware('auth')->name('servicios.eliminar');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->middleware('auth')->name('servicios.destroy');
Route::get('/servicios/consultar', [ServicioController::class, 'consultar'])->name('servicios.consultar');
Route::get('/servicios/consultar/reporte', [ServicioController::class, 'reporte'])->name('servicios.consultar.reporte');
Route::get('/servicios/estado', [ServicioController::class, 'estado'])->middleware('auth')->name('servicios.estado');
Route::put('/servicios/estado/{id}', [ServicioController::class, 'estadoUpdate']);
Route::put('/servicios/estado/{id}', [ServicioController::class, 'estadoUpdate'])->middleware('auth')->name('servicios.estado.update');
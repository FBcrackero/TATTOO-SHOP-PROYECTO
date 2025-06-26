<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InventarioController;


/**
 * Rutas web para la aplicación PROTOTIPO_TATTOOSHOP.
 *
 * - Redirige la URL raíz a '/inicio'.
 * - Sirve la vista 'inicio' en '/inicio'.
 * - Maneja el cierre de sesión del usuario, limpia la sesión 'carrito' y redirige al login.
 * - Sirve la vista 'dashboard', protegida por los middlewares 'auth' y 'verified'.
 * - Rutas de gestión de perfil (editar, actualizar, eliminar) bajo el middleware 'auth'.
 * - Rutas de productos, servicios, carrito y reservas, todas protegidas por el middleware 'auth'.
 *
 * Controladores utilizados:
 * - ProfileController: Maneja acciones del perfil de usuario.
 * - ProductoController: Maneja el listado de productos.
 * - ServicioController: Maneja el listado de servicios.
 * - CarritoController: Maneja acciones del carrito de compras.
 * - ReservaController: Maneja acciones de reservas.
 */
Route::get('/', function () {
    return redirect('/inicio');
});

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::post('/logout', function () {
    session()->forget('carrito'); // Vacía el carrito de la sesión
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios');
    Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index');
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas');
});


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


Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/departamentos/{pais_id}', [RegisteredUserController::class, 'getDepartamentos']);
Route::get('/ciudades/{departamento_id}', [RegisteredUserController::class, 'getCiudades']);


/**
 * Rutas web para la gestión de servicios (ServicioController)
 *
 * - GET    /servicios/ingresar           : Formulario para ingresar servicio (requiere autenticación)
 * - POST   /servicios                    : Almacena un nuevo servicio (requiere autenticación)
 * - GET    /servicios/modificar          : Formulario para modificar servicio (requiere autenticación)
 * - PUT    /servicios/{id}               : Actualiza un servicio (requiere autenticación)
 * - GET    /servicios/eliminar           : Formulario para eliminar servicio (requiere autenticación)
 * - DELETE /servicios/{id}               : Elimina un servicio (requiere autenticación)
 * - GET    /servicios/consultar          : Consulta servicios
 * - GET    /servicios/consultar/reporte  : Genera reporte de servicios
 * - GET    /servicios/estado             : Consulta estado de servicios (requiere autenticación)
 * - PUT    /servicios/estado/{id}        : Actualiza estado de servicio (requiere autenticación)
 */

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


/**
 * Rutas web para la gestión de productos.
 *
 * - POST   /productos                 : Almacena un nuevo producto (requiere autenticación)
 * - GET    /productos/ingresar        : Formulario para ingresar producto
 * - GET    /productos/modificar       : Formulario para modificar producto
 * - PUT    /productos/{id}            : Actualiza un producto
 * - GET    /productos/eliminar        : Formulario para eliminar producto
 * - DELETE /productos/{id}            : Elimina un producto
 * - GET    /productos/consultar       : Consulta productos
 * - GET    /productos/consultar/reporte: Genera reporte de productos
 * - GET    /productos/estado          : Consulta estado de productos
 * - PUT    /productos/estado/{id}     : Actualiza estado de producto
 */

Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store')->middleware('auth');
Route::get('/productos/ingresar', [ProductoController::class, 'create'])->name('productos.ingresar');
Route::get('/productos/modificar', [ProductoController::class, 'modificar'])->name('productos.modificar');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::get('/productos/eliminar', [ProductoController::class, 'eliminar'])->name('productos.eliminar');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::get('/productos/consultar', [ProductoController::class, 'consultar'])->name('productos.consultar');
Route::get('/productos/consultar/reporte', [ProductoController::class, 'reporte'])->name('productos.consultar.reporte');
Route::get('/productos/estado', [ProductoController::class, 'estado'])->name('productos.estado');
Route::put('/productos/estado/{id}', [ProductoController::class, 'estadoUpdate'])->name('productos.estado.update');


/**
 * Rutas web para la gestión de Reservas
 *
 * Este bloque define las rutas HTTP para gestionar las "reservas" en la aplicación.
 * Todas las rutas son manejadas por el ReservaController y algunas requieren el middleware de autenticación.
 *
 * Rutas:
 * - GET    /reservas                      : Lista todas las reservas (requiere autenticación)
 * - POST   /reservas                      : Almacena una nueva reserva (requiere autenticación)
 * - PUT    /reservas/{reserva}/cancelar   : Cancela una reserva específica
 * - PUT    /reservas/{reserva}/aceptar    : Acepta una reserva específica
 * - PUT    /reservas/{reserva}/rechazar   : Rechaza una reserva específica
 * - GET    /reservas/ingresar             : Formulario para ingresar reserva (requiere autenticación)
 * - POST   /reservas/ingresar             : Almacena reserva desde admin (requiere autenticación)
 * - GET    /reservas/modificar            : Formulario para modificar reserva (requiere autenticación)
 * - PUT    /reservas/{reserva}/modificar  : Actualiza una reserva (requiere autenticación)
 * - GET    /reservas/eliminar             : Formulario para eliminar reserva (requiere autenticación)
 * - DELETE /reservas/{reserva}            : Elimina una reserva (requiere autenticación)
 * - GET    /reservas/consultar            : Consulta reservas
 * - GET    /reservas/estado               : Consulta estado de reservas
 * - PUT    /reservas/estado/{id}          : Actualiza estado de reserva
 * - GET    /buscar                        : Búsqueda general
 * - GET    /reservas/consultar/reporte    : Genera reporte de reservas
 */

Route::get('/reservas', [ReservaController::class, 'index'])->middleware('auth')->name('reservas');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store')->middleware('auth');
Route::put('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
Route::put('/reservas/{reserva}/aceptar', [ReservaController::class, 'aceptar'])->name('reservas.aceptar');
Route::put('/reservas/{reserva}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar');
Route::get('/reservas/ingresar', [ReservaController::class, 'create'])->middleware('auth')->name('reservas.ingresar');
Route::post('/reservas/ingresar', [ReservaController::class, 'storeAdmin'])->middleware('auth')->name('reservas.store.admin');
Route::get('/reservas/modificar', [ReservaController::class, 'modificar'])->middleware('auth')->name('reservas.modificar');
Route::put('/reservas/{reserva}/modificar', [ReservaController::class, 'update'])->middleware('auth')->name('reservas.update');
Route::get('/reservas/eliminar', [ReservaController::class, 'eliminar'])->middleware('auth')->name('reservas.eliminar');
Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->middleware('auth')->name('reservas.destroy');
Route::get('/reservas/consultar', [ReservaController::class, 'consultar'])->name('reservas.consultar');
Route::get('/reservas/estado', [ReservaController::class, 'estado'])->name('reservas.estado');
Route::put('/reservas/estado/{id}', [ReservaController::class, 'actualizarEstado'])->name('reservas.estado.update');
Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar');
Route::get('/reservas/consultar/reporte', [ReservaController::class, 'reporte'])->name('reservas.consultar.reporte');

/**
 * Rutas web para los módulos de configuración de la aplicación.
 *
 * Todas las rutas están protegidas con el middleware 'auth' para asegurar que solo usuarios autenticados accedan.
 *
 * Módulos:
 * - Configuración general: /configuracion
 * - Tipos de documento: /configuracion/tipodocumento
 * - Categorías: /configuracion/categoria
 * - Estados: /configuracion/estado
 * - Empleados: /configuracion/empleado
 * - Cargos: /configuracion/cargo
 * - Formas de pago: /configuracion/formaPago
 *
 * Cada módulo implementa operaciones CRUD y otras funcionalidades relacionadas.
 * Nota: Algunas rutas pueden estar duplicadas o ser redundantes, revisar para optimización.
 */

Route::get('/configuracion', [ConfiguracionController::class, 'index'])->middleware('auth')->name('configuracion');

Route::prefix('configuracion/tipodocumento')->middleware('auth')->group(function () {
    Route::get('/', [TipoDocumentoController::class, 'index'])->name('tipodocumento');
    Route::get('/ingresar', [TipoDocumentoController::class, 'create'])->name('tipodocumento.ingresar');
    Route::get('/modificar', [TipoDocumentoController::class, 'modificar'])->name('tipodocumento.modificar');
    Route::get('/eliminar', [TipoDocumentoController::class, 'eliminar'])->name('tipodocumento.eliminar');
    Route::get('/consultar', [TipoDocumentoController::class, 'consultar'])->name('tipodocumento.consultar');
    Route::get('/estado', [TipoDocumentoController::class, 'estado'])->name('tipodocumento.estado');
});

Route::post('/configuracion/tipodocumento/ingresar', [TipoDocumentoController::class, 'store'])->name('tipodocumento.store');
Route::put('/configuracion/tipodocumento/{id}', [TipoDocumentoController::class, 'update'])->name('tipodocumento.update');
Route::delete('/configuracion/tipodocumento/{id}', [TipoDocumentoController::class, 'destroy'])->name('tipodocumento.destroy');
Route::get('/configuracion/tipodocumento/consultar', [TipoDocumentoController::class, 'consultar'])->name('tipodocumento.consultar');
Route::get('/configuracion/tipodocumento/consultar/reporte', [TipoDocumentoController::class, 'reporte'])->name('tipodocumento.consultar.reporte');
Route::get('/estado', [TipoDocumentoController::class, 'estado'])->name('tipodocumento.estado');
Route::put('/estado/{id}', [TipoDocumentoController::class, 'estadoUpdate'])->name('tipodocumento.estado.update');

Route::prefix('configuracion/categoria')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria');
    Route::get('/ingresar', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categoria.ingresar');
    Route::post('/ingresar', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categoria.store');
    Route::get('/modificar', [App\Http\Controllers\CategoriaController::class, 'modificar'])->name('categoria.modificar');
    Route::put('/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categoria.update');
    Route::get('/eliminar', [App\Http\Controllers\CategoriaController::class, 'eliminar'])->name('categoria.eliminar');
    Route::delete('/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categoria.destroy');
    Route::get('/consultar', [App\Http\Controllers\CategoriaController::class, 'consultar'])->name('categoria.consultar');
    Route::get('/consultar/reporte', [App\Http\Controllers\CategoriaController::class, 'reporte'])->name('categoria.consultar.reporte');
    Route::get('/estado', [App\Http\Controllers\CategoriaController::class, 'estado'])->name('categoria.estado');
    Route::put('/estado/{id}', [App\Http\Controllers\CategoriaController::class, 'estadoUpdate'])->name('categoria.estado.update');
    Route::get('/estado', [App\Http\Controllers\CategoriaController::class, 'estado'])->name('categoria.estado');
    Route::put('/estado/{id}', [App\Http\Controllers\CategoriaController::class, 'estadoUpdate'])->name('categoria.estado.update');
});

Route::prefix('configuracion/estado')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\EstadoController::class, 'index'])->name('estado');
    Route::get('/ingresar', [App\Http\Controllers\EstadoController::class, 'create'])->name('estado.ingresar');
    Route::post('/ingresar', [App\Http\Controllers\EstadoController::class, 'store'])->name('estado.store');
    Route::get('/modificar', [App\Http\Controllers\EstadoController::class, 'modificar'])->name('estado.modificar');
    Route::put('/{id}', [App\Http\Controllers\EstadoController::class, 'update'])->name('estado.update');
    Route::get('/eliminar', [App\Http\Controllers\EstadoController::class, 'eliminar'])->name('estado.eliminar');
    Route::delete('/{id}', [App\Http\Controllers\EstadoController::class, 'destroy'])->name('estado.destroy');
    Route::get('/consultar', [App\Http\Controllers\EstadoController::class, 'consultar'])->name('estado.consultar');
    Route::get('/consultar/reporte', [App\Http\Controllers\EstadoController::class, 'reporte'])->name('estado.consultar.reporte');
});

Route::prefix('configuracion/empleado')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\EmpleadoController::class, 'index'])->name('empleado');
    Route::get('/ingresar', [App\Http\Controllers\EmpleadoController::class, 'create'])->name('empleado.ingresar');
    Route::post('/ingresar', [App\Http\Controllers\EmpleadoController::class, 'store'])->name('empleado.store');
    Route::get('/modificar', [App\Http\Controllers\EmpleadoController::class, 'modificar'])->name('empleado.modificar');
    Route::put('/{id}/modificar', [App\Http\Controllers\EmpleadoController::class, 'update'])->name('empleado.update');
    Route::get('/configuracion/empleado/eliminar', [App\Http\Controllers\EmpleadoController::class, 'eliminar'])->name('empleado.eliminar');
    Route::delete('/configuracion/empleado/{id}/eliminar', [App\Http\Controllers\EmpleadoController::class, 'destroy'])->name('empleado.destroy');
    Route::get('/consultar', [App\Http\Controllers\EmpleadoController::class, 'consultar'])->name('empleado.consultar');
    Route::get('/consultar/reporte', [App\Http\Controllers\EmpleadoController::class, 'reporte'])->name('empleado.consultar.reporte');
    Route::get('/estado', [App\Http\Controllers\EmpleadoController::class, 'estado'])->name('empleado.estado');
    Route::put('/{id}/estado', [App\Http\Controllers\EmpleadoController::class, 'actualizarEstado'])->name('empleado.estado.update');
});

Route::prefix('configuracion/cargo')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CargoController::class, 'index'])->name('cargo');
    Route::get('/ingresar', [App\Http\Controllers\CargoController::class, 'create'])->name('cargo.ingresar');
    Route::post('/ingresar', [App\Http\Controllers\CargoController::class, 'store'])->name('cargo.store');
    Route::get('/modificar', [App\Http\Controllers\CargoController::class, 'modificar'])->name('cargo.modificar');
    Route::put('/{id}/modificar', [App\Http\Controllers\CargoController::class, 'update'])->name('cargo.update');
    Route::get('/eliminar', [App\Http\Controllers\CargoController::class, 'eliminar'])->name('cargo.eliminar');
    Route::delete('/{id}/eliminar', [App\Http\Controllers\CargoController::class, 'destroy'])->name('cargo.destroy');
    Route::get('/consultar', [App\Http\Controllers\CargoController::class, 'consultar'])->name('cargo.consultar');
    Route::get('/consultar/reporte', [App\Http\Controllers\CargoController::class, 'reporte'])->name('cargo.consultar.reporte');
    Route::get('/estado', [App\Http\Controllers\CargoController::class, 'estado'])->name('cargo.estado');
    Route::put('/{id}/estado', [App\Http\Controllers\CargoController::class, 'actualizarEstado'])->name('cargo.estado.update');
});

Route::prefix('configuracion/formaPago')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\FormaPagoController::class, 'index'])->name('formaPago');
    Route::get('/ingresar', [App\Http\Controllers\FormaPagoController::class, 'create'])->name('formaPago.ingresar');
    Route::post('/ingresar', [App\Http\Controllers\FormaPagoController::class, 'store'])->name('formaPago.store');
    Route::get('/modificar', [App\Http\Controllers\FormaPagoController::class, 'modificar'])->name('formaPago.modificar');
    Route::put('/{id}/modificar', [App\Http\Controllers\FormaPagoController::class, 'update'])->name('formaPago.update');
    Route::get('/eliminar', [App\Http\Controllers\FormaPagoController::class, 'eliminar'])->name('formaPago.eliminar');
    Route::delete('/{id}/eliminar', [App\Http\Controllers\FormaPagoController::class, 'destroy'])->name('formaPago.destroy');
    Route::get('/consultar', [App\Http\Controllers\FormaPagoController::class, 'consultar'])->name('formaPago.consultar');
    Route::get('/consultar/reporte', [App\Http\Controllers\FormaPagoController::class, 'reporte'])->name('formaPago.consultar.reporte');
    Route::get('/estado', [App\Http\Controllers\FormaPagoController::class, 'estado'])->name('formaPago.estado');
    Route::put('/{id}/estado', [App\Http\Controllers\FormaPagoController::class, 'actualizarEstado'])->name('formaPago.estado.update');
});


/**
 * Rutas para la gestión del carrito de compras y el proceso de checkout.
 *
 * - POST /carrito/agregar/{codProducto}: Agrega un producto al carrito.
 * - POST /carrito/quitar/{codProducto}: Quita un producto del carrito.
 * - POST /carrito/vaciar: Vacía todo el carrito.
 * - POST /carrito/actualizar/{codProducto}: Actualiza la cantidad de un producto en el carrito.
 * - GET /checkout: Muestra la página de checkout.
 * - POST /checkout: Procesa la orden de compra durante el checkout.
 *
 * Todas las rutas están asociadas al controlador CarritoController.
 */

Route::post('/carrito/agregar/{codProducto}', [App\Http\Controllers\CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/quitar/{codProducto}', [App\Http\Controllers\CarritoController::class, 'quitar'])->name('carrito.quitar');
Route::post('/carrito/vaciar', [App\Http\Controllers\CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/actualizar/{codProducto}', [App\Http\Controllers\CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::get('/checkout', [App\Http\Controllers\CarritoController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CarritoController::class, 'procesarCheckout'])->name('checkout.procesar');


/**
 * Rutas web para la gestión de perfil de usuario, historial y reportes de facturas,
 * y administración de usuarios (crear, modificar, eliminar, actualizar estado y asignar roles).
 *
 * Rutas:
 * - /perfil: Ver perfil de usuario (requiere autenticación).
 * - /factura/historial: Ver historial de facturas.
 * - /facturas/reporte: Generar reportes de facturas.
 * - /facturas/consultar: Consultar facturas.
 * - /usuarios/ingresar: Formulario para agregar nuevo usuario.
 * - /usuarios/store: Guardar nuevo usuario.
 * - /usuarios/modificar: Formulario para modificar usuario.
 * - /usuarios/update/{idUsuario}: Actualizar información de usuario.
 * - /usuarios/eliminar: Formulario para eliminar usuario.
 * - /usuarios/destroy/{idUsuario}: Eliminar usuario.
 * - /usuarios/consultar: Consultar usuarios.
 * - /usuarios/consultar/reporte: Generar reportes de usuarios.
 * - /usuarios/estado: Ver estado de usuarios.
 * - /usuarios/estado/{idUsuario}: Actualizar estado de usuario.
 * - /usuarios/asignar-rol: Asignar roles a usuarios.
 *
 * Controladores utilizados:
 * - PerfilController
 * - FacturaController
 * - UsuarioController
 *
 * Middleware:
 * - Se aplica el middleware 'auth' a las rutas de perfil para asegurar que solo usuarios autenticados accedan.
 */


Route::get('/perfil', [PerfilController::class, 'ver'])->name('perfil.ver')->middleware('auth');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar')->middleware('auth');
Route::get('/factura/historial', [FacturaController::class, 'historial'])->name('factura.historial');
Route::get('/facturas/reporte', [FacturaController::class, 'reporte'])->name('facturas.reporte');
Route::get('/facturas/consultar', [App\Http\Controllers\FacturaController::class, 'consultar'])->name('facturas.consultar');
Route::get('/usuarios/ingresar', [PerfilController::class, 'ingresarUsuario'])->name('usuarios.ingresar');
Route::post('/usuarios/store', [PerfilController::class, 'storeUsuario'])->name('usuarios.store');
Route::get('/usuarios/modificar', [PerfilController::class, 'modificarUsuario'])->name('usuarios.modificar');
Route::put('/usuarios/update/{idUsuario}', [PerfilController::class, 'updateUsuario'])->name('usuarios.update');
Route::get('/usuarios/eliminar', [PerfilController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
Route::delete('/usuarios/destroy/{idUsuario}', [PerfilController::class, 'destroyUsuario'])->name('usuarios.destroy');
Route::get('/usuarios/consultar', [PerfilController::class, 'consultarUsuarios'])->name('usuarios.consultar');
Route::get('/usuarios/consultar/reporte', [PerfilController::class, 'reporteUsuarios'])->name('usuarios.consultar.reporte');
Route::get('/usuarios/estado', [PerfilController::class, 'estado'])->name('usuarios.estado');
Route::put('/usuarios/estado/{idUsuario}', [PerfilController::class, 'actualizarEstado'])->name('usuarios.estado.update');
Route::get('/usuarios/asignar-rol', [UsuarioController::class, 'asignarRol'])->name('usuarios.asignarRol');



/**
 * Rutas web para la gestión de inventario
 *
 * - GET  /inventario                : Muestra la página principal del inventario. (inventario.index)
 * - POST /inventario/entrada        : Registra una nueva entrada de inventario. (inventario.entrada.store)
 * - GET  /inventario/entrada        : Muestra el formulario/página de entrada de inventario. (inventario.entrada)
 * - GET  /inventario/kardex         : Consulta el Kardex de inventario. (inventario.kardex)
 * - GET  /inventario/kardex/reporte : Genera un reporte del Kardex. (inventario.kardex.reporte)
 *
 * Todas las rutas son gestionadas por el InventarioController.
 */

Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
Route::post('/inventario/entrada', [InventarioController::class, 'registrarEntrada'])->name('inventario.entrada.store');
Route::get('/inventario/entrada', [InventarioController::class, 'entrada'])->name('inventario.entrada');
Route::get('/inventario/kardex', [InventarioController::class, 'consultarKardex'])->name('inventario.kardex');
Route::get('/inventario/kardex/reporte', [InventarioController::class, 'reporteKardex'])->name('inventario.kardex.reporte');
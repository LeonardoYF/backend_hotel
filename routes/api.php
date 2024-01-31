<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\RegisteredUserController;
use App\Http\Controllers\auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('categorias','CategoriaController');
Route::apiResource('nivels','NivelController');
Route::apiResource('detalles','DetalleController');
Route::apiResource('habitacions','HabitacionController');
Route::apiResource('reservacions','ReservacionController');
Route::apiResource('recepcions','RecepcionController');
Route::apiResource('tags','TagController');
Route::apiResource('productos','ProductoController');
Route::apiResource('users','UserController');
Route::apiResource('cajas','CajaController');
Route::post('reservar','ReservacionController@store');
Route::post('habitaciones','HabitacionController@habitaciones');
Route::post('logout','UserController@logout');
Route::post('crear-usuario', 'UserController@store');
Route::put('reservacions-reajuste/{reservacion}','ReservacionController@reajuste');
Route::post('habitacion-disponibilidad/{habitacion}','HabitacionController@disponibilidad');
Route::post('habitacion-limpiar/{habitacion}','HabitacionController@limpiar');
Route::post('habitacion-nolimpiar/{habitacion}','HabitacionController@noLimpiar');
Route::post('recepcion-despachar/{recepcion}','RecepcionController@despachar');
Route::post('iniciar-sesion','UserController@iniciarSesion');
Route::post('recepcion-finalizar/{recepcion}','RecepcionController@finalizar');
Route::post('consultar-documento','ClienteController@documento');
Route::post('cajas-cerrar/{caja}','CajaController@cerrar');
Route::get('habitacions-recepcion','HabitacionController@recepcionList');
Route::get('habitacion-recepcions/{habitacion}','HabitacionController@recepecion');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    if ($request->user()) {
        // Eliminar todos los tokens del usuario
        $request->user()->tokens()->delete();

        // Cerrar sesión
        Auth::guard('web')->logout();
    }
    return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
});


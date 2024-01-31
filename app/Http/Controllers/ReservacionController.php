<?php

namespace App\Http\Controllers;

use App\Models\Adelanto;
use App\Models\Cliente;
use App\Models\Movimiento;
use App\Models\Reservacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reservacion::where('estado', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación: Verificar que la fecha de inicio no sea mayor que la fecha de fin
        if ($request->fechaInicioDate > $request->fechaFinDate) {
            return response()->json(['error' => 'La fecha de inicio no puede ser mayor que la fecha de fin'], 422);
        }
    
        // Crear una nueva instancia de Reservacion
        $reservacion = new Reservacion();
    
        // Asignar los datos recibidos del frontend a los atributos de la reservación
        $reservacion->start = Carbon::createFromFormat('Y-m-d', $request->fechaInicioDate);
        $reservacion->end = Carbon::createFromFormat('Y-m-d', $request->fechaFinDate);
        $reservacion->habitacion_id = $request->habitacion['id'];
        $reservacion->title = $request->title;
        $reservacion->precio = $request->total;
    
        // Guardar la reservación en la base de datos
        $reservacion->save();
    
        // Devolver una respuesta indicando que la reservación se ha creado exitosamente
        return response()->json(['success' => 'Reservación creada exitosamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function show(Reservacion $reservacion)
    {
        return $reservacion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservacion $reservacion)
    {
        $reservacion->start = $request->start;
        $reservacion->end = $request->end;
        $reservacion->save();
        return $reservacion;
    }
    public function reajuste(Request $request, Reservacion $reservacion)
    {

        $reservacion->start = $request->start;
        $reservacion->end = $request->end;
        $reservacion->title = $request->title;
        $reservacion->precio = $request->precio;
        $reservacion->active = $request->active;
        if (floatval($request->adelanto) > 0) {
            $adelanto = new Adelanto();
            $adelanto->monto = $request->adelanto;
            $adelanto->reservacion_id = $reservacion->id;
            $adelanto->save();
            $movimiento = new Movimiento();
            $movimiento->monto = $adelanto->monto;
            $movimiento->caja_id = $request->caja_id;
            $movimiento->detalle = "ADELANTO POR RESERVACION";
            $movimiento->save();
        }

        $reservacion->save();
        return $reservacion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservacion $reservacion)
    {
        $reservacion->estado = 0;
        $reservacion->save();
        return $reservacion;
    }
}

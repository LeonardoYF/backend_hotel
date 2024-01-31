<?php

namespace App\Http\Controllers;

use App\Models\Adelanto;
use App\Models\Habitacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Detalle;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function habitaciones(Request $request)
    {
        $query = Habitacion::query();

        if ($request->has('name') && $request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('categoria_id') && $request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->has('detalle_id') && $request->filled('detalle_id')) {
            $query->where('detalle_id', $request->detalle_id);
        }

        $habitaciones = $query
            ->where('estado', 1)
            ->get(['id', 'name', 'precio']);

        return [
            'habitaciones' => $habitaciones,
            'categorias' => Categoria::select('id', 'name')->get(),
            'detalles' => Detalle::select('id', 'name')->get()
        ];
    }
    public function index()
    {
        return Habitacion::with(['Categoria', 'Nivel', 'Detalle'])->where('estado', 1)->get();
    }
    public function recepcionList()
    {
        return Habitacion::with(['Categoria', 'Detalle', 'RecepcionWithoutProductos'])->where('estado', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $habitacion = new Habitacion();
        $habitacion->name = $request->name;
        $habitacion->categoria_id = $request->categoria_id;
        $habitacion->nivel_id = $request->nivel_id;
        $habitacion->detalle_id = $request->detalle_id;
        $habitacion->precio = $request->precio;

        $habitacion->save();
        return $habitacion;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function recepecion(Habitacion $habitacion)
    {
        $habitacion->nivel = $habitacion->Nivel;
        $habitacion->recepcion = $habitacion->Recepcion;

        return $habitacion;
    }
    public function limpiar(Habitacion $habitacion)
    {
        $habitacion->active = 3;
        $habitacion->save();

        return $habitacion;
    }
    public function noLimpiar(Habitacion $habitacion)
    {
        $habitacion->active = 1;
        $habitacion->save();

        return $habitacion;
    }
    public function show(Habitacion $habitacion)
    {
        $habitacion->nivel = $habitacion->Nivel;
        $habitacion->reservacions = $habitacion->Reservacions()->get()->each(function ($reservacion) {
            $reservacion->days = Carbon::parse($reservacion->start)->diffInDays($reservacion->end);
            if ($reservacion->start == $reservacion->end) {
                $reservacion->days = 1;
            }
            $reservacion->adelantoSum = $reservacion->Adelantos()->get()->sum('monto');
            $reservacion->adelanto = 0;
        });
        return $habitacion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        $habitacion->name = $request->name;
        $habitacion->categoria_id = $request->categoria_id;
        $habitacion->nivel_id = $request->nivel_id;
        $habitacion->detalle_id = $request->detalle_id;
        $habitacion->precio = $request->precio;

        $habitacion->save();
        return $habitacion;
    }
    public function disponibilidad(Request $request, Habitacion $habitacion)
    {
        $hoy = Carbon::now();
        $start = $hoy->format('Y-m-d');
        $end = $hoy->addDays($request->dias)->format('Y-m-d');
        $reservas = $habitacion->Reservacions()->whereDate('start', '>=', $start)->whereDate('end', '<=', $end)->get();
        $res = [
            "start" => $start,
            "end" => $end,
            "hora_start" => $hoy->format('H:i'),
            "hora_end" => $hoy->addDays($request->dias)->format('H:i'),
            "dias" => $request->dias,
            "reservas" => $reservas
        ];
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habitacion $habitacion)
    {
        $habitacion->estado = 0;
        $habitacion->save();
        return $habitacion;
    }
}

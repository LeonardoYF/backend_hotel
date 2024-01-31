<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Caja::with(['User'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $caja = new Caja();
        $caja->inicial = $request->inicial;
        $caja->user_id = $request->user_id;
        $caja->start = Carbon::now();
        $caja->save();
        return $caja;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function show(Caja $caja)
    {
        $caja->total = $caja->Movimientos()->sum('monto');
        $caja->total += $caja->inicial;
        return $caja;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
  
        $caja->save();
        return $caja;
    }
    public function cerrar(Request $request, Caja $caja)
    {
        $caja->final = $request->total;
        $caja->diferencia = $request->final;
        $caja->estado = 0;
        $caja->end = Carbon::now();
        $caja->save();
        return $caja;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caja $caja)
    {
        $caja->estado = 0;
        $caja->save();
        return $caja;
    }
}

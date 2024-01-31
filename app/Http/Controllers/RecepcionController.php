<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use App\Models\Recepcion;
use App\Models\RecepcionProducto;
use Illuminate\Http\Request;

class RecepcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recepcion::where('estado',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clienteRequest = $request->cliente;
        $cliente = Cliente::where('doc',$clienteRequest['documento'])->get();
        if($cliente->count()>0){
            $cliente = $cliente->first();
        }else{
            $cliente = new Cliente();
            $cliente->name = $clienteRequest['name'];
            $cliente->telefono = $clienteRequest['telefono'];
            $cliente->direccion = $clienteRequest['direccion'];
            $cliente->doc = $clienteRequest['documento'];
            $cliente->save();
        }
        $recepcion = new Recepcion();
        $recepcion->precio = $request->precio;
        $recepcion->dias = $request->dias;
        $recepcion->start = $request->start;
        $recepcion->end = $request->end;
        $recepcion->hora_end = $request->hora_end;
        $recepcion->hora_start = $request->hora_start;
        $recepcion->habitacion_id = $request->habitacion_id;
        $recepcion->adelanto = $request->adelanto;
        $recepcion->cliente_id = $cliente->id;
        $recepcion->save();
        $recepcion->habitacion->active = 2;
        $recepcion->habitacion->save();
        return $recepcion;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function show(Recepcion $recepcion)
    {
        return $recepcion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recepcion $recepcion)
    {
        $recepcion->name = $request->name;
        $recepcion->save();
        return $recepcion;
    }
    public function despachar(Request $request, Recepcion $recepcion)
    {
        if(isset($request->cart)){
            foreach($request->cart as $cart){
                $recepcionProducto = new RecepcionProducto();
                $recepcionProducto->cantidad = $cart['cantidad'];
                $recepcionProducto->venta = $cart['venta'];
                $recepcionProducto->producto_id = $cart['producto']['id'];
                $recepcionProducto->recepcion_id = $recepcion->id;
                $recepcionProducto->save();
            }
        }
        return $recepcion;
    }
    public function finalizar(Request $request, Recepcion $recepcion)
    {
        $recepcion->active = 0;
        $recepcion->save();
        $recepcion->habitacion->active = 1;
        $recepcion->habitacion->save();
        $movimiento = new Movimiento();
        $movimiento->monto = $request->pendiente;
        $movimiento->caja_id = $request->caja_id;
        $movimiento->detalle = "FINALIZAR RECEPCION";
        $movimiento->save();
        return $recepcion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recepcion  $recepcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recepcion $recepcion)
    {
        $recepcion->estado = 0;
        $recepcion->save();
        return $recepcion;
    }
}

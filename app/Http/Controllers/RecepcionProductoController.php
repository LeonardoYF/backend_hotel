<?php

namespace App\Http\Controllers;

use App\Models\RecepcionProducto;
use Illuminate\Http\Request;

class RecepcionProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RecepcionProducto::where('estado',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recepcionProducto = new RecepcionProducto();
        $recepcionProducto->name = $request->name;
        $recepcionProducto->save();
        return $recepcionProducto;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecepcionProducto  $recepcionProducto
     * @return \Illuminate\Http\Response
     */
    public function show(RecepcionProducto $recepcionProducto)
    {
        return $recepcionProducto;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecepcionProducto  $recepcionProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecepcionProducto $recepcionProducto)
    {
        $recepcionProducto->name = $request->name;
        $recepcionProducto->save();
        return $recepcionProducto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecepcionProducto  $recepcionProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecepcionProducto $recepcionProducto)
    {
        $recepcionProducto->estado = 0;
        $recepcionProducto->save();
        return $recepcionProducto;
    }
}

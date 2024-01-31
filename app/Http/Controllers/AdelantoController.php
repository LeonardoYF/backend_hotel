<?php

namespace App\Http\Controllers;

use App\Models\Adelanto;
use Illuminate\Http\Request;

class AdelantoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Adelanto::where('estado',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adelanto = new Adelanto();
        $adelanto->name = $request->name;
        $adelanto->save();
        return $adelanto;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adelanto  $adelanto
     * @return \Illuminate\Http\Response
     */
    public function show(Adelanto $adelanto)
    {
        return $adelanto;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adelanto  $adelanto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adelanto $adelanto)
    {
        $adelanto->name = $request->name;
        $adelanto->save();
        return $adelanto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adelanto  $adelanto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adelanto $adelanto)
    {
        $adelanto->estado = 0;
        $adelanto->save();
        return $adelanto;
    }
}

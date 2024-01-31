<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    use HasFactory;
    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function Habitacion(){
        return $this->belongsTo(Habitacion::class);
    }
    public function RecepcionProductos(){
        return $this->hasMany(RecepcionProducto::class)->with(['Producto']);
    }
}

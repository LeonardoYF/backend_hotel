<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    public function Categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function Nivel(){
        return $this->belongsTo(Nivel::class);
    }
    public function Detalle(){
        return $this->belongsTo(Detalle::class);
    }
    public function Reservacions(){
        return $this->hasMany(Reservacion::class)->where('estado',1);
    }
    public function Recepcion(){
        return $this->hasOne(Recepcion::class)->with(['Cliente','RecepcionProductos'])->where([['estado',1],['active',1]])->orderBy('id','desc');
    }
    public function RecepcionWithoutProductos(){
        return $this->hasOne(Recepcion::class)->with(['Cliente'])->where([['estado',1],['active',1]])->orderBy('id','desc');
    }
}

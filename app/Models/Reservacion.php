<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    use HasFactory;
    public function Adelantos(){
        return $this->hasMany(Adelanto::class)->where('estado',1);
    }
}

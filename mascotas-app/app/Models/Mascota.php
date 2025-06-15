<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'edad',
        'raza',
        'peso',
        'fecha_adopcion',
    ];
}

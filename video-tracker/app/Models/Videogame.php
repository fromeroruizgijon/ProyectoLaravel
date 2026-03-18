<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videogame extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'genero', 'plataforma', 'puntuacion_media', 'user_id', 'estado'];
    //
}

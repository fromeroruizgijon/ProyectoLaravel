<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'genero', 'portada', 'portada_url', 'igdb_id'];

    // Un juego global tiene muchas entradas en las bibliotecas de los usuarios
    public function videogames()
    {
        return $this->hasMany(Videogame::class);
    }
    public function notaMedia()
    {
        // Accede a la tabla videogames y hace la media de la puntuación
        return $this->videogames()->avg('puntuacion_personal') ?: 0;
    }
    public function comments() {
        return $this->hasMany(Comment::class)->latest(); // El latest() es para que los nuevos salgan arriba
    }
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
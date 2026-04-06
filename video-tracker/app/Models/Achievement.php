<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. Importar el Trait
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory; // 2. Usar el Trait dentro de la clase

    protected $fillable = ['game_id', 'nombre', 'descripcion', 'imagen_url'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'achievement_user');
    }
}
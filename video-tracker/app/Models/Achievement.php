<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['game_id', 'nombre', 'descripcion', 'imagen_url'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}

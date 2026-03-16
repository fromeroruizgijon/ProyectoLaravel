<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use Illuminate\Http\Request;

class VideogameController extends Controller
{
    public function index()
    {
        $videojuegos = Videogame::all();
        
        return view('biblioteca', compact('videojuegos'));
    }
}

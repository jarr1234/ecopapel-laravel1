<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    public function index()
    {
        $categorias = DB::table('categorias')
            ->orderBy('nombre')
            ->get();

        return view('inicio', [
            'categorias' => $categorias,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = DB::table('categorias')
            ->orderBy('nombre')
            ->get();

        $query = DB::table('productos as p')
            ->leftJoin(
                'categorias as c',
                'p.categoria_id',
                '=',
                'c.id'
            )
            ->select(
                'p.*',
                'c.nombre as categoria'
            );

        if ($request->filled('categoria')) {
            $query->where(
                'p.categoria_id',
                $request->integer('categoria')
            );
        }

        if ($request->filled('buscar')) {
            $buscar = trim($request->input('buscar'));

            $query->where(function ($q) use ($buscar) {
                $q->where(
                    'p.nombre',
                    'like',
                    '%' . $buscar . '%'
                )
                ->orWhere(
                    'p.descripcion',
                    'like',
                    '%' . $buscar . '%'
                )
                ->orWhere(
                    'c.nombre',
                    'like',
                    '%' . $buscar . '%'
                );
            });
        }

        $productos = $query
            ->orderBy('p.nombre')
            ->get();

        return view('productos', [
            'productos' => $productos,
            'categorias' => $categorias,
        ]);
    }
}
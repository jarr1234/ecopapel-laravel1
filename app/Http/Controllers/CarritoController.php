<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    private function auth()
    {
        return session()->has('id');
    }

    public function agregar(Request $request)
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }

        $datos = $request->validate([
            'id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = DB::table('productos')
            ->where('id', $datos['id'])
            ->first();

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($producto->stock <= 0) {
            return back()->with('error', 'Producto agotado.');
        }

        if ($datos['cantidad'] > $producto->stock) {
            return back()->with('error', 'No hay suficiente stock.');
        }

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        if (!$carritoId) {
            $carritoId = DB::table('carrito')->insertGetId([
                'usuario_id' => session('id'),
                'ip_usuario' => $request->ip(),
            ]);
        }

        $item = DB::table('item_carrito')
            ->where('carrito_id', $carritoId)
            ->where('producto_id', $producto->id)
            ->first();

        $cantidadActual = $item ? $item->cantidad : 0;

        $cantidadNueva = $cantidadActual + $datos['cantidad'];

        if ($cantidadNueva > $producto->stock) {
            return back()->with(
                'error',
                'La cantidad solicitada supera el stock disponible.'
            );
        }

        $subtotal = $cantidadNueva * $producto->precio;

        if ($item) {
            DB::table('item_carrito')
                ->where('id', $item->id)
                ->update([
                    'cantidad' => $cantidadNueva,
                    'subtotal' => $subtotal,
                ]);
        } else {
            DB::table('item_carrito')->insert([
                'carrito_id' => $carritoId,
                'producto_id' => $producto->id,
                'cantidad' => $cantidadNueva,
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()
            ->route('carrito')
            ->with('ok', 'Producto agregado al carrito.');
    }

    public function index()
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        $items = collect();

        if ($carritoId) {
            $items = DB::table('item_carrito as i')
                ->join(
                    'productos as p',
                    'i.producto_id',
                    '=',
                    'p.id'
                )
                ->where('i.carrito_id', $carritoId)
                ->select(
                    'i.id',
                    'i.carrito_id',
                    'i.producto_id',
                    'i.cantidad',
                    'i.subtotal',
                    'p.nombre',
                    'p.precio',
                    'p.imagen',
                    'p.stock'
                )
                ->get();
        }

        $total = $items->sum('subtotal');

        return view('carrito', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function eliminar($id)
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        if (!$carritoId) {
            return redirect()->route('carrito');
        }

        DB::table('item_carrito')
            ->where('id', $id)
            ->where('carrito_id', $carritoId)
            ->delete();

        $quedanProductos = DB::table('item_carrito')
            ->where('carrito_id', $carritoId)
            ->exists();

        if (!$quedanProductos) {
            DB::table('carrito')
                ->where('id', $carritoId)
                ->delete();
        }

        return redirect()
            ->route('carrito')
            ->with('ok', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        if ($carritoId) {
            DB::transaction(function () use ($carritoId) {
                DB::table('item_carrito')
                    ->where('carrito_id', $carritoId)
                    ->delete();

                DB::table('carrito')
                    ->where('id', $carritoId)
                    ->delete();
            });
        }

        return redirect()
            ->route('carrito')
            ->with('ok', 'Carrito vaciado correctamente.');
    }
}
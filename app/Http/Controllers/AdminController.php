<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function guard()
    {
        abort_unless(session('rol') === 'admin', 403);
    }

    public function index()
    {
        $this->guard();

        return view('admin.index', [
            'productos' => DB::table('productos')->count(),
            'usuarios' => DB::table('usuarios')->count(),
            'ventas' => DB::table('ventas')->count(),
        ]);
    }

    public function productos()
    {
        $this->guard();

        $productos = DB::table('productos as p')
            ->leftJoin('categorias as c', 'p.categoria_id', '=', 'c.id')
            ->select('p.*', 'c.nombre as categoria')
            ->orderByDesc('p.id')
            ->get();

        $categorias = DB::table('categorias')
            ->orderBy('nombre')
            ->get();

        return view('admin.productos', compact(
            'productos',
            'categorias'
        ));
    }

    public function verProductos(Request $request)
    {
        $this->guard();

        $consulta = DB::table('productos as p')
            ->leftJoin('categorias as c', 'p.categoria_id', '=', 'c.id')
            ->select(
                'p.id',
                'p.nombre',
                'p.descripcion',
                'p.precio',
                'p.stock',
                'p.imagen',
                'p.categoria_id',
                'c.nombre as categoria'
            );

        if ($request->filled('buscar')) {
            $buscar = trim($request->input('buscar'));

            $consulta->where(function ($query) use ($buscar) {
                $query->where('p.nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('p.descripcion', 'like', '%' . $buscar . '%')
                    ->orWhere('c.nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('p.precio', 'like', '%' . $buscar . '%');
            });
        }

        $productos = $consulta
            ->orderByDesc('p.id')
            ->get();

        return view('admin.ver-productos', compact('productos'));
    }

    public function guardarProducto(Request $request)
    {
        $this->guard();

        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');

            $nombreImagen = time() . '_' . preg_replace(
                '/[^A-Za-z0-9._-]/',
                '_',
                $archivo->getClientOriginalName()
            );

            $archivo->move(
                public_path('imagenes'),
                $nombreImagen
            );

            $imagen = 'imagenes/' . $nombreImagen;
        }

        DB::table('productos')->insert([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
            'categoria_id' => $datos['categoria_id'],
            'imagen' => $imagen,
        ]);

        return redirect()
            ->route('admin.productos.ver')
            ->with('ok', 'Producto agregado correctamente.');
    }

    public function editarProducto($id)
    {
        $this->guard();

        $producto = DB::table('productos')
            ->where('id', $id)
            ->first();

        if (!$producto) {
            return redirect()
                ->route('admin.productos.ver')
                ->with('error', 'El producto no existe.');
        }

        $categorias = DB::table('categorias')
            ->orderBy('nombre')
            ->get();

        return view('admin.editar-producto', compact(
            'producto',
            'categorias'
        ));
    }

    public function actualizarProducto(Request $request, $id)
    {
        $this->guard();

        $producto = DB::table('productos')
            ->where('id', $id)
            ->first();

        if (!$producto) {
            return redirect()
                ->route('admin.productos.ver')
                ->with('error', 'El producto no existe.');
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $imagen = $producto->imagen;

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');

            $nombreImagen = time() . '_' . preg_replace(
                '/[^A-Za-z0-9._-]/',
                '_',
                $archivo->getClientOriginalName()
            );

            $archivo->move(
                public_path('imagenes'),
                $nombreImagen
            );

            $imagen = 'imagenes/' . $nombreImagen;
        }

        DB::table('productos')
            ->where('id', $id)
            ->update([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'precio' => $datos['precio'],
                'stock' => $datos['stock'],
                'categoria_id' => $datos['categoria_id'],
                'imagen' => $imagen,
            ]);

        return redirect()
            ->route('admin.productos.ver')
            ->with('ok', 'Producto actualizado correctamente.');
    }

    public function eliminarProducto($id)
    {
        $this->guard();

        $producto = DB::table('productos')
            ->where('id', $id)
            ->first();

        if (!$producto) {
            return redirect()
                ->route('admin.productos.ver')
                ->with('error', 'El producto no existe.');
        }

        try {
            DB::table('productos')
                ->where('id', $id)
                ->delete();

            return redirect()
                ->route('admin.productos.ver')
                ->with('ok', 'Producto eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('admin.productos.ver')
                ->with(
                    'error',
                    'No se puede eliminar este producto porque está relacionado con una venta o un carrito.'
                );
        }
    }

    public function usuarios()
    {
        $this->guard();

        $usuarios = DB::table('usuarios')
            ->orderByDesc('id')
            ->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    public function guardarUsuario(Request $request)
    {
        $this->guard();

        $datos = $request->validate([
            'usuario' => 'required|string|max:100',
            'correo' => 'nullable|email|max:255',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,cliente',
        ]);

        $existeUsuario = DB::table('usuarios')
            ->where('usuario', $datos['usuario'])
            ->exists();

        if ($existeUsuario) {
            return back()
                ->withInput()
                ->with('error', 'Ese nombre de usuario ya existe.');
        }

        if (!empty($datos['correo'])) {
            $existeCorreo = DB::table('usuarios')
                ->where('correo', $datos['correo'])
                ->exists();

            if ($existeCorreo) {
                return back()
                    ->withInput()
                    ->with('error', 'Ese correo ya está registrado.');
            }
        }

        DB::table('usuarios')->insert([
            'usuario' => $datos['usuario'],
            'correo' => $datos['correo'] ?? null,
            'password' => Hash::make($datos['password']),
            'rol' => $datos['rol'],
            'verificado' => 1,
        ]);

        return back()
            ->with('ok', 'Usuario agregado correctamente.');
    }

    public function eliminarUsuario($id)
    {
        $this->guard();

        if ((int) session('id') === (int) $id) {
            return back()->with(
                'error',
                'No puedes eliminar tu propia cuenta.'
            );
        }

        $usuario = DB::table('usuarios')
            ->where('id', $id)
            ->first();

        if (!$usuario) {
            return back()
                ->with('error', 'El usuario no existe.');
        }

        DB::table('usuarios')
            ->where('id', $id)
            ->delete();

        return back()
            ->with('ok', 'Usuario eliminado correctamente.');
    }

    public function categorias()
    {
        $this->guard();

        $categorias = DB::table('categorias')
            ->orderBy('nombre')
            ->get();

        return view('admin.categorias', compact('categorias'));
    }

    public function guardarCategoria(Request $request)
    {
        $this->guard();

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $existe = DB::table('categorias')
            ->where('nombre', $datos['nombre'])
            ->exists();

        if ($existe) {
            return back()
                ->with('error', 'Esa categoría ya existe.');
        }

        DB::table('categorias')->insert([
            'nombre' => $datos['nombre'],
        ]);

        return back()
            ->with('ok', 'Categoría agregada correctamente.');
    }

    public function eliminarCategoria($id)
    {
        $this->guard();

        $categoria = DB::table('categorias')
            ->where('id', $id)
            ->first();

        if (!$categoria) {
            return back()
                ->with('error', 'La categoría no existe.');
        }

        $tieneProductos = DB::table('productos')
            ->where('categoria_id', $id)
            ->exists();

        if ($tieneProductos) {
            return back()->with(
                'error',
                'No puedes eliminar esta categoría porque tiene productos asociados.'
            );
        }

        DB::table('categorias')
            ->where('id', $id)
            ->delete();

        return back()
            ->with('ok', 'Categoría eliminada correctamente.');
    }

    public function ventas()
    {
        $this->guard();

        $ventas = DB::table('ventas')
            ->orderByDesc('fecha')
            ->get();

        return view('admin.ventas', compact('ventas'));
    }

    public function entregar($id)
    {
        $this->guard();

        $venta = DB::table('ventas')
            ->where('id', $id)
            ->first();

        if (!$venta) {
            return back()
                ->with('error', 'La venta no existe.');
        }

        DB::table('ventas')
            ->where('id', $id)
            ->update([
                'estado' => 'entregado',
            ]);

        return back()
            ->with('ok', 'Venta marcada como entregada.');
    }

    public function cortes(Request $request)
    {
        $this->guard();

        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $consulta = DB::table('ventas');

        if ($desde) {
            $consulta->whereDate('fecha', '>=', $desde);
        }

        if ($hasta) {
            $consulta->whereDate('fecha', '<=', $hasta);
        }

        $ventas = $consulta
            ->orderByDesc('fecha')
            ->get();

        $totalVentas = $ventas->count();
        $totalDinero = $ventas->sum('total');

        $totalEfectivo = $ventas
            ->where('metodo_pago', 'Efectivo')
            ->sum('total');

        $totalTarjeta = $ventas
            ->where('metodo_pago', 'Tarjeta')
            ->sum('total');

        $totalTransferencia = $ventas
            ->where('metodo_pago', 'Transferencia')
            ->sum('total');

        return view('admin.cortes', compact(
            'ventas',
            'totalVentas',
            'totalDinero',
            'totalEfectivo',
            'totalTarjeta',
            'totalTransferencia',
            'desde',
            'hasta'
        ));
    }
}
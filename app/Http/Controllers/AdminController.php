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
            ->where('corte', 0)
            ->orderByDesc('id')
            ->get();

        return view('admin.ventas', compact('ventas'));
    }

    public function entregar($id)
    {
        $this->guard();

        $venta = DB::table('ventas')
            ->where('id', $id)
            ->where('corte', 0)
            ->first();

        if (!$venta) {
            return back()
                ->with('error', 'La venta no existe o ya fue incluida en un corte.');
        }

        DB::table('ventas')
            ->where('id', $id)
            ->update([
                'estado' => 'Entregado',
            ]);

        return back()
            ->with('ok', 'Venta marcada como entregada.');
    }

    public function cortes()
    {
        $this->guard();

        $carpeta = public_path('cortes');

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $archivos = glob(
            $carpeta . DIRECTORY_SEPARATOR . '*.pdf'
        );

        if ($archivos === false) {
            $archivos = [];
        }

        usort($archivos, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });

        $cortes = collect($archivos)->map(function ($archivo) {
            return [
                'nombre' => basename($archivo),
                'fecha' => date(
                    'd/m/Y H:i:s',
                    filemtime($archivo)
                ),
            ];
        });

        return view(
            'admin.cortes',
            compact('cortes')
        );
    }

    public function verCorte($archivo)
    {
        $this->guard();

        $archivo = basename($archivo);

        if (
            strtolower(
                pathinfo($archivo, PATHINFO_EXTENSION)
            ) !== 'pdf'
        ) {
            abort(404);
        }

        $ruta = public_path(
            'cortes/' . $archivo
        );

        if (!file_exists($ruta)) {
            abort(404);
        }

        return response()->file(
            $ruta,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'inline; filename="' .
                    $archivo .
                    '"',
            ]
        );
    }

    public function generarCorteDia()
    {
        $this->guard();

        $ventas = DB::table('ventas')
            ->where('corte', 0)
            ->whereRaw('LOWER(estado) = ?', ['entregado'])
            ->orderByDesc('id')
            ->get();

        if ($ventas->isEmpty()) {
            return redirect()
                ->route('admin.ventas')
                ->with(
                    'error',
                    'No hay ventas entregadas pendientes para generar corte.'
                );
        }

        $totalVentas = $ventas->count();
        $totalDinero = $ventas->sum('total');

        require_once public_path(
            'fpdf/fpdf.php'
        );

        $pdf = new \FPDF();
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();

        $pdf->SetFont(
            'Arial',
            'B',
            16
        );

        $pdf->Cell(
            190,
            10,
            'CORTE DEL DIA',
            0,
            1,
            'C'
        );

        $pdf->Ln(5);

        $ahora = now('America/Mexico_City');

        $pdf->SetFont(
            'Arial',
            '',
            12
        );

        $pdf->Cell(
            190,
            8,
            'Fecha: ' .
            $ahora->format('d/m/Y'),
            0,
            1
        );

        $pdf->Cell(
            190,
            8,
            'Hora: ' .
            $ahora->format('H:i:s'),
            0,
            1
        );

        $pdf->Ln(5);

        $pdf->SetFont(
            'Arial',
            'B',
            10
        );

        $pdf->Cell(
            15,
            10,
            'ID',
            1
        );

        $pdf->Cell(
            55,
            10,
            'Cliente',
            1
        );

        $pdf->Cell(
            35,
            10,
            'Total',
            1
        );

        $pdf->Cell(
            40,
            10,
            'Metodo',
            1
        );

        $pdf->Cell(
            45,
            10,
            'Estado',
            1
        );

        $pdf->Ln();

        $pdf->SetFont(
            'Arial',
            '',
            9
        );

        foreach ($ventas as $venta) {
            $usuario = $this->textoPdf(
                $venta->usuario
            );

            $metodo = $this->textoPdf(
                $venta->metodo_pago
            );

            $estado = $this->textoPdf(
                $venta->estado
            );

            if (strlen($usuario) > 28) {
                $usuario =
                    substr(
                        $usuario,
                        0,
                        25
                    ) .
                    '...';
            }

            $pdf->Cell(
                15,
                10,
                $venta->id,
                1
            );

            $pdf->Cell(
                55,
                10,
                $usuario,
                1
            );

            $pdf->Cell(
                35,
                10,
                '$' .
                number_format(
                    $venta->total,
                    2
                ),
                1
            );

            $pdf->Cell(
                40,
                10,
                $metodo,
                1
            );

            $pdf->Cell(
                45,
                10,
                $estado,
                1
            );

            $pdf->Ln();
        }

        $pdf->Ln(5);

        $pdf->SetFont(
            'Arial',
            'B',
            12
        );

        $pdf->Cell(
            190,
            10,
            'Ventas realizadas: ' .
            $totalVentas,
            1,
            1,
            'C'
        );

        $pdf->Cell(
            190,
            10,
            'Total vendido: $' .
            number_format(
                $totalDinero,
                2
            ),
            1,
            1,
            'C'
        );

        $carpeta = public_path(
            'cortes'
        );

        if (!is_dir($carpeta)) {
            mkdir(
                $carpeta,
                0777,
                true
            );
        }

        $nombreArchivo =
            'corte_' .
            $ahora->format(
                'Y-m-d_H-i-s'
            ) .
            '.pdf';

        $ruta =
            $carpeta .
            DIRECTORY_SEPARATOR .
            $nombreArchivo;

        $pdf->Output(
            'F',
            $ruta
        );

        $idsVentas = $ventas
            ->pluck('id')
            ->toArray();

        DB::table('ventas')
            ->whereIn('id', $idsVentas)
            ->update([
                'corte' => 1,
            ]);

        return response()->file(
            $ruta,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $nombreArchivo .
                    '"',
            ]
        );
    }

    private function textoPdf($texto)
    {
        $convertido = iconv(
            'UTF-8',
            'windows-1252//TRANSLIT',
            $texto
        );

        return $convertido !== false
            ? $convertido
            : $texto;
    }
}
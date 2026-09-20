<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function form()
    {
        if (!session()->has('id')) {
            return redirect()->route('login');
        }

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        if (!$carritoId) {
            return redirect()
                ->route('productos')
                ->with('error', 'El carrito está vacío.');
        }

        $items = DB::table('item_carrito')
            ->where('carrito_id', $carritoId)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('productos')
                ->with('error', 'El carrito está vacío.');
        }

        return view('comprar');
    }

    public function procesar(Request $request)
    {
        if (!session()->has('id')) {
            return redirect()->route('login');
        }

        $datos = $request->validate([
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'metodo_pago' => 'required|string|max:50',
        ]);

        $carritoId = DB::table('carrito')
            ->where('usuario_id', session('id'))
            ->value('id');

        if (!$carritoId) {
            return redirect()
                ->route('productos')
                ->with('error', 'El carrito está vacío.');
        }

        $items = DB::table('item_carrito as i')
            ->join(
                'productos as p',
                'i.producto_id',
                '=',
                'p.id'
            )
            ->where('i.carrito_id', $carritoId)
            ->select(
                'i.producto_id',
                'i.cantidad',
                'p.nombre',
                'p.precio',
                'p.stock'
            )
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('productos')
                ->with('error', 'El carrito está vacío.');
        }

        foreach ($items as $item) {
            if ($item->stock < $item->cantidad) {
                return redirect()
                    ->route('carrito')
                    ->with(
                        'error',
                        'No hay suficiente stock de ' . $item->nombre . '.'
                    );
            }
        }

        try {
            $resultado = DB::transaction(function () use (
                $datos,
                $items,
                $carritoId
            ) {
                $total = $items->sum(function ($item) {
                    return $item->precio * $item->cantidad;
                });

                $ventaId = DB::table('ventas')->insertGetId([
                    'usuario' => session('usuario'),
                    'telefono' => $datos['telefono'],
                    'total' => $total,
                    'metodo_pago' => $datos['metodo_pago'],
                    'direccion' => $datos['direccion'],
                    'fecha' => now(),
                ]);

                foreach ($items as $item) {
                    $producto = DB::table('productos')
                        ->where('id', $item->producto_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$producto) {
                        throw new \Exception(
                            'Uno de los productos ya no existe.'
                        );
                    }

                    if ($producto->stock < $item->cantidad) {
                        throw new \Exception(
                            'No hay suficiente stock de ' .
                            $producto->nombre . '.'
                        );
                    }

                    DB::table('detalle_venta')->insert([
                        'venta_id' => $ventaId,
                        'producto_id' => $item->producto_id,
                        'precio' => $producto->precio,
                        'cantidad' => $item->cantidad,
                    ]);

                    DB::table('productos')
                        ->where('id', $item->producto_id)
                        ->decrement(
                            'stock',
                            $item->cantidad
                        );
                }

                DB::table('item_carrito')
                    ->where('carrito_id', $carritoId)
                    ->delete();

                DB::table('carrito')
                    ->where('id', $carritoId)
                    ->delete();

                return [
                    'ventaId' => $ventaId,
                    'total' => $total,
                ];
            });

            $this->generarTicket(
                $resultado['ventaId'],
                $items,
                $resultado['total'],
                $datos
            );

            return redirect()
                ->route(
                    'compra.comprobante',
                    $resultado['ventaId']
                );

        } catch (\Exception $e) {
            return redirect()
                ->route('carrito')
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    private function generarTicket(
        $ventaId,
        $items,
        $total,
        $datos
    ) {
        require_once public_path('fpdf/fpdf.php');

        $pdf = new \FPDF();

        $pdf->AddPage();

        $logo = public_path('imagenes/logo2.png');

        if (file_exists($logo)) {
            $pdf->Image(
                $logo,
                10,
                8,
                25
            );
        }

        $pdf->SetFont(
            'Arial',
            'B',
            16
        );

        $pdf->Cell(
            0,
            10,
            'ECOPAPEL',
            0,
            1,
            'C'
        );

        $pdf->SetFont(
            'Arial',
            '',
            11
        );

        $pdf->Cell(
            0,
            8,
            'Comprobante de compra',
            0,
            1,
            'C'
        );

        $pdf->Ln(10);

        $pdf->SetFont(
            'Arial',
            '',
            11
        );

        $pdf->Cell(
            0,
            8,
            'Folio: #' . $ventaId,
            0,
            1
        );

        $pdf->Cell(
            0,
            8,
            'Fecha: ' . date('d/m/Y H:i'),
            0,
            1
        );

        $pdf->Cell(
            0,
            8,
            $this->textoPdf(
                'Cliente: ' . session('usuario')
            ),
            0,
            1
        );

        $pdf->Cell(
            0,
            8,
            $this->textoPdf(
                'Telefono: ' . $datos['telefono']
            ),
            0,
            1
        );

        $pdf->MultiCell(
            0,
            8,
            $this->textoPdf(
                'Direccion: ' . $datos['direccion']
            )
        );

        $pdf->Cell(
            0,
            8,
            $this->textoPdf(
                'Metodo de pago: ' .
                $datos['metodo_pago']
            ),
            0,
            1
        );

        $pdf->Ln(7);

        $pdf->SetFont(
            'Arial',
            'B',
            10
        );

        $pdf->Cell(
            80,
            10,
            'Producto',
            1,
            0,
            'C'
        );

        $pdf->Cell(
            25,
            10,
            'Cant.',
            1,
            0,
            'C'
        );

        $pdf->Cell(
            40,
            10,
            'Precio',
            1,
            0,
            'C'
        );

        $pdf->Cell(
            45,
            10,
            'Subtotal',
            1,
            1,
            'C'
        );

        $pdf->SetFont(
            'Arial',
            '',
            10
        );

        foreach ($items as $item) {
            $subtotal =
                $item->precio *
                $item->cantidad;

            $nombre = $this->textoPdf(
                $item->nombre
            );

            if (strlen($nombre) > 35) {
                $nombre =
                    substr($nombre, 0, 32) .
                    '...';
            }

            $pdf->Cell(
                80,
                10,
                $nombre,
                1
            );

            $pdf->Cell(
                25,
                10,
                $item->cantidad,
                1,
                0,
                'C'
            );

            $pdf->Cell(
                40,
                10,
                '$' . number_format(
                    $item->precio,
                    2
                ),
                1,
                0,
                'R'
            );

            $pdf->Cell(
                45,
                10,
                '$' . number_format(
                    $subtotal,
                    2
                ),
                1,
                1,
                'R'
            );
        }

        $pdf->Ln(7);

        $pdf->SetFont(
            'Arial',
            'B',
            14
        );

        $pdf->Cell(
            0,
            10,
            'Total: $' .
            number_format(
                $total,
                2
            ),
            0,
            1,
            'R'
        );

        $pdf->Ln(10);

        $pdf->SetFont(
            'Arial',
            '',
            11
        );

        $pdf->Cell(
            0,
            10,
            $this->textoPdf(
                'Gracias por tu compra'
            ),
            0,
            1,
            'C'
        );

        $carpeta = public_path('tickets');

        if (!is_dir($carpeta)) {
            mkdir(
                $carpeta,
                0777,
                true
            );
        }

        $ruta = $carpeta .
            DIRECTORY_SEPARATOR .
            'ticket_' .
            $ventaId .
            '.pdf';

        $pdf->Output(
            'F',
            $ruta
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

    public function comprobante($id)
    {
        if (!session()->has('id')) {
            return redirect()->route('login');
        }

        $venta = DB::table('ventas')
            ->where('id', $id)
            ->first();

        if (!$venta) {
            return redirect()
                ->route('productos')
                ->with(
                    'error',
                    'La venta no existe.'
                );
        }

        if (
            session('rol') !== 'admin' &&
            $venta->usuario !== session('usuario')
        ) {
            abort(403);
        }

        $rutaPdf = public_path(
            'tickets/ticket_' . $id . '.pdf'
        );

        if (!file_exists($rutaPdf)) {
            return redirect()
                ->route('productos')
                ->with(
                    'error',
                    'No se encontró el PDF de esta compra.'
                );
        }

        return response()->file(
            $rutaPdf,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'inline; filename="ticket_' .
                    $id .
                    '.pdf"',
            ]
        );
    }
}
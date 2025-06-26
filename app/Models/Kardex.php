<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model

{
    protected $table = 'kardex';
    public $timestamps = false;
    
    protected $fillable = [
        'cantKardEntrada',
        'cantKardSalida',
        'precioVenta',
        'fechaInventario',
        'codProducto',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto', 'codProducto');
    }

    public function reporteKardex(Request $request)
    {
        $query = \App\Models\Kardex::with('producto');

        if ($request->filled('tipo')) {
            if ($request->tipo == 'entrada') {
                $query->where('cantKardEntrada', '>', 0);
            } elseif ($request->tipo == 'salida') {
                $query->where('cantKardSalida', '>', 0);
            }
        }
        if ($request->filled('producto')) {
            $query->where('codProducto', $request->producto);
        }
        if ($request->filled('fecha')) {
            $query->where('fechaInventario', $request->fecha);
        }

        $kardex = $query->orderBy('fechaInventario', 'desc')->get();

        return view('inventario.reporteKardex', compact('kardex'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pedidos pendientes estado 0
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //almacenar un pedido
        $pedido = new Pedido;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

        /**
         * Almacena el detalle
         */
        
        //obtener el id de pedido
        $id = $pedido->id;

        //obtener los productos
        $productos = $request->productos;
        
        //formatear un arreglo
        $pedido_producto = [];

        foreach ($productos as $p ) {
            # code...
            $pedido_producto[] = [
                'pedido_id' => $id,
                'producto_id' => $p['id'],
                'cantidad' => $p['cantidad'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
             ] ;
        }

        //almacenar en la base de datos
        PedidoProducto::insert($pedido_producto) ;



        return [
            'message' => 'Pedido realizado correctamente. Estará listo en unos minutos.',
            'productos' =>   $request->productos,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
        $pedido->estado = 1;
        $pedido->save();

        return [
            'pedido' => $pedido
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}

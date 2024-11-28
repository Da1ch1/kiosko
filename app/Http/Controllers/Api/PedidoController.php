<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Crea un nuevo pedido y asocia los productos seleccionados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Asegurarse de que el usuario está autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Validar los datos del pedido
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Crear el pedido con el ID del usuario autenticado
            $pedido = Pedido::create([
                'user_id' => $user->id, // Usar el ID del usuario autenticado
                'total' => $request->total,
                'estado' => 0, // Estado inicial del pedido
            ]);

            // Asociar los productos al pedido
            foreach ($request->productos as $producto) {
                $pedido->productos()->attach($producto['id'], ['cantidad' => $producto['cantidad']]);
            }

            DB::commit();

            return response()->json($pedido, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear el pedido: '.$e->getMessage());
            return response()->json(['error' => 'Error al crear el pedido', 'message' => $e->getMessage()], 500);
        }
    }
}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Formatea la URL de la imagen para un producto.
     *
     * @param  \App\Models\Producto  $producto
     * @return \App\Models\Producto
     */
    protected function formatProductImage($producto)
    {
        if ($producto->imagen) {
            $producto->imagen = asset('img/' . $producto->imagen . '.jpg');
        }
        return $producto;
    }

    /**
     * Obtiene todos los productos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $productos = Producto::all();

        if ($productos->isEmpty()) {
            return response()->json(['error' => 'No hay productos disponibles'], 404);
        }
        $productos->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productos);
    }
    // Método para crear un nuevo producto
    public function store(Request $request)
    {
        // Validación de los datos del producto
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Imagen ahora es opcional
            'disponible' => 'boolean',
            'categoria_id' => 'required|exists:categorias,id', // Asumiendo que tienes una tabla 'categorias'
        ]);

        // Inicializar la variable de imagen
        $imagen = null;

        // Verificar si se ha enviado una imagen en la solicitud
        if ($request->hasFile('imagen')) {
            // Guardar la imagen en storage/app/productos
            $imagen = $request->file('imagen')->store('productos');
        }

        // Crear el producto en la base de datos
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'imagen' => $imagen, // Asignar la imagen guardada o null si no se proporcionó
            'disponible' => $request->input('disponible', 1), // Valor por defecto 1 si no se proporciona
            'categoria_id' => $request->categoria_id,
        ]);

        // Retornar la respuesta en formato JSON con código de estado 201 (Created)
        return response()->json($producto, 201);
    }

    // Método para obtener un producto por ID
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($producto);
    }

    // Método para actualizar un producto por ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación opcional para imagen
            'disponible' => 'boolean',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Actualizar los campos del producto
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->disponible = $request->input('disponible', 1); // Valor por defecto 1 si no se proporciona
        $producto->categoria_id = $request->categoria_id;

        // Actualizar la imagen si se proporciona
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            Storage::delete($producto->imagen);

            // Guardar la nueva imagen
            $imagen = $request->file('imagen')->store('productos');
            $producto->imagen = $imagen;
        }

        $producto->save();

        return response()->json($producto, 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);
    
        if (!$producto) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Eliminar la imagen asociada al producto si existe
        if ($producto->imagen) {
            Storage::delete($producto->imagen);
        }
    
        $producto->delete();
    
        return response()->json(['message' => 'Product deleted'], 200);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
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
            $producto->imagen = asset('img/' . $producto->imagen . '.jpg'); // Ajusta aquí la extensión si no es .jpg
        }
        return $producto;
    }

    /**
     * Obtiene todos los productos de la categoría "Café".
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCafe()
    {
        $categoriaCafe = Categoria::where('nombre', 'Café')->first();

        if (!$categoriaCafe) {
            return response()->json(['error' => 'Categoría Café no encontrada'], 404);
        }

        $productosCafe = $categoriaCafe->productos()->get();
        $productosCafe->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productosCafe);
    }

    // Métodos similares para otras categorías...

    public function getDonas()
    {
        $categoriaDonas = Categoria::where('nombre', 'Donas')->first();

        if (!$categoriaDonas) {
            return response()->json(['error' => 'Categoría Donas no encontrada'], 404);
        }

        $productosDonas = $categoriaDonas->productos()->get();
        $productosDonas->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productosDonas);
    }

    public function getHamburguesas()
    {
        $categoriaHamburguesas = Categoria::where('nombre', 'Hamburguesas')->first();

        if (!$categoriaHamburguesas) {
            return response()->json(['error' => 'Categoría Hamburguesas no encontrada'], 404);
        }

        $productosHamburguesas = $categoriaHamburguesas->productos()->get();
        $productosHamburguesas->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productosHamburguesas);
    }

    public function getPizzas()
    {
        $categoriaPizzas = Categoria::where('nombre', 'Pizzas')->first();

        if (!$categoriaPizzas) {
            return response()->json(['error' => 'Categoría Pizzas no encontrada'], 404);
        }

        $productosPizzas = $categoriaPizzas->productos()->get();
        $productosPizzas->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productosPizzas);
    }

    public function getPasteles()
    {
        try {
            $categoriaPasteles = Categoria::where('nombre', 'Pasteles')->firstOrFail();
            $productosPasteles = $categoriaPasteles->productos()->get();
            $productosPasteles->transform(function ($producto) {
                return $this->formatProductImage($producto);
            });

            return response()->json($productosPasteles);
        } catch (\Exception $e) {
            \Log::error('Error al cargar los productos de Pasteles: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar los productos de Pasteles'], 500);
        }
    }

    public function getGalletas()
    {
        $categoriaGalletas = Categoria::where('nombre', 'Galletas')->first();

        if (!$categoriaGalletas) {
            return response()->json(['error' => 'Categoría Galletas no encontrada'], 404);
        }

        $productosGalletas = $categoriaGalletas->productos()->get();
        $productosGalletas->transform(function ($producto) {
            return $this->formatProductImage($producto);
        });

        return response()->json($productosGalletas);
    }
}
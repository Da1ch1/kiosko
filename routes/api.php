<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\API\CategoriaController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta para la autenticacion y obtener el token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
    ]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
// Route saves for Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Route to get all orders
    Route::post('/pedidos', [PedidoController::class, 'store']);

    // Route  CRUD to the products
    Route::post('/productos', [ProductoController::class, 'store']);
    Route::get('/productos/{id}', [ProductoController::class, 'show']);
    Route::put('/productos/{id}', [ProductoController::class, 'update']);
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);
});

Route::get('/categorias/cafe', [CategoriaController::class, 'getCafe']);
Route::get('/categorias/donas', [CategoriaController::class, 'getDonas']);
Route::get('/categorias/hamburguesas', [CategoriaController::class, 'getHamburguesas']);
Route::get('/categorias/pizzas', [CategoriaController::class, 'getPizzas']);
Route::get('/categorias/pasteles', [CategoriaController::class, 'getPasteles']);
Route::get('/categorias/galletas', [CategoriaController::class, 'getGalletas']);
// Ruta para obtener todos los productos
Route::get('/productos', [ProductoController::class, 'index']);

// Ruta para servir imágenes
Route::get('/images/{filename}', [ImageController::class, 'show'])->name('images.show');
Route::get('/pedidos', [PedidoController::class, 'index']);

<?php

namespace App\Livewire;

use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Resumen extends Component
{
    public $pedidos;
    public $total = 0;

    public function __construct()
    {
        $this->pedidos = new Collection();

    }

    public function calTotal(){
        // Calcular el total usando reduce
        $this->total = $this->pedidos->reduce(function ($total, $pedido) {
            return $total + ($pedido['precio'] * $pedido['cantidad']);
        }, 0);
    }

    public function isPedido(){
        return $this->pedidos->isEmpty();
    }

    #[On('setPedido')]
    public function setPedido($pedido)
    {

        $pedidoCollect = collect($pedido);
        //Verificar que el producto no este en el pedido
        if($this->pedidos->contains('id', $pedidoCollect->get('id'))){
            $this->dispatch('alertaAgregado');
        }else{
            $this->pedidos->push($pedidoCollect);
            $this->dispatch('productoAgregado');
            $this->calTotal();
        }
    }

    #[On('editPedido')]
    public function editPedido($pedidoEdit)
    {

        $pedidoId = $pedidoEdit['id'];

        // Encuentra el índice del pedido que quieres editar
        $index = $this->pedidos->search(function ($pedido) use ($pedidoId) {
            return $pedido['id'] === $pedidoId;
        });

        if ($index !== false) {
            // Actualiza la cantidad en el índice encontrado
           $this->pedidos[$index]['cantidad'] = $pedidoEdit['cantidad'];
           $this->dispatch('productoEditado');
           $this->calTotal();
        }
    }

    public function eliminarProducto($id){

        $this->pedidos = $this->pedidos->reject(function ($item) use ($id) {
            return $item['id'] === $id;
        });
        $this->dispatch('productoEliminado');
        $this->calTotal();
    }

    public function confirmPedido(){


        //Almacenar Pedido u Orden
        $pedido = new Pedido;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $this->total;
        $pedido->save();

        //Obtener Id del pedido
        $idPedido = $pedido->id;

        //Obtener los Productos
        $productos = $this->pedidos->map(function ($producto,) {
            return [
                'id' => $producto['id'],
                'cantidad' => $producto['cantidad']
            ];
        });

        //Formatear Arreglo
        $order_product = [];
        foreach ($productos as $product) {
            $order_product[] = [
                'pedido_id' => $idPedido,
                'producto_id' => $product['id'],
                'cantidad' => $product['cantidad'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        //Almacenar en la BD
        PedidoProducto::insert($order_product); //Insert permite ingresar o almacenar un arreglo
        $this->pedidos = collect();
        $this->total = 0;
        $this->dispatch('pedidoConfirmado');
    }



    public function render()
    {

        return view('livewire.resumen');
    }
}

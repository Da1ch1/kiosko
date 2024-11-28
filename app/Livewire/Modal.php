<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class Modal extends ModalComponent
{
    public $producto;
    public $cantidad;
    public $edit = false;


    public function mount()
    {
        // Inicializas la cantidad con el valor de 'cantidad' de $producto, o 1 si no está presente
        $this->cantidad = $this->producto['cantidad'] ?? 1;
        //dump($this->producto);

    }

    public function incrementQuantity()
    {
        $this->cantidad++;
    }

    public function decrementQuantity()
    {
        if($this->cantidad <= 1)
        {
            return;
        }
        $this->cantidad--;
    }



    public function addProduct()
    {

        $productoPedido = [
            'id' => $this->producto['id'],
            'imagen' => $this->producto['imagen'],
            'nombre' => $this->producto['nombre'],
            'precio' => $this->producto['precio'],
            'cantidad' => $this->cantidad
        ];
        $this->dispatch('setPedido', pedido: $productoPedido);
        $this->closeModal();
    }

    public function editProduct()
    {
       $this->producto['cantidad'] = $this->cantidad;
        $this->dispatch('editPedido', pedidoEdit: $this->producto);
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modal');
    }
}

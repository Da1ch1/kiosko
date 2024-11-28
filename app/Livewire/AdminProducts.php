<?php

namespace App\Livewire;

use App\Models\Producto;
use Livewire\Component;

class AdminProducts extends Component
{
    public $products;

    public function productOutOfStock($id)
    {
        $pedido = Producto::where('id', $id)->first();

        if ($pedido) {
            $pedido->disponible = 0;
            $pedido->save();
            $this->dispatch('productOutOfStock');
        }
    }

    public function productAvailable($id)
    {
        $pedido = Producto::where('id', $id)->first();

        if ($pedido) {
            $pedido->disponible = 1;
            $pedido->save();
            $this->dispatch('productAvailable');
        }
    }

    public function render()
    {
        $this->products = Producto::all();

        return view('livewire.admin-products');
    }
}

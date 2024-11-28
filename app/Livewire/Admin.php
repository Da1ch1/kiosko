<?php

namespace App\Livewire;

use App\Models\Pedido;
use Livewire\Component;

class Admin extends Component
{
    public $pedidos;

    public function completar($id)
    {
        $pedido = Pedido::where('id', $id)->first();

        if ($pedido) {
            $pedido->estado = 1;
            $pedido->save();
            $this->dispatch('ordenCompletada');
        }
    }

    public function render()
    {
        $this->pedidos = Pedido::where('estado', 0)->get();
        return view('livewire.admin');
    }
}

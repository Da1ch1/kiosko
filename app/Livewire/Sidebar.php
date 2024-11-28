<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;

class Sidebar extends Component
{

    public $currentCategory = 1;
    public $modal = false;

    public function filterCategory($idCategory)
    {
        $this->dispatch('filter-category', idCategory: $idCategory);
        $this->currentCategory = $idCategory;
    }


    public function render()
    {
        $categorias = Categoria::all();

        return view('livewire.sidebar',[
            'categorias' => $categorias
        ]);
    }

}

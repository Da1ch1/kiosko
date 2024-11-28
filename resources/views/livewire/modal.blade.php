<div class="md:flex gap-10 p-5">
    <div class="md:w-1/3">
        <img class=""  src="{{ asset('img/' . $producto['imagen'] . '.jpg') }}" alt="Imagen del Producto">
    </div>
    <div class="md:w-2/3">
        <div class="flex justify-end">
            <button wire:click="$dispatch('closeModal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <h1 class="text-3xl font-bold mt-5">{{$producto['nombre']}}</h1>
        <p class="mt-5 font-black text-5xl text-amber-500">${{ number_format($producto['precio'], 2) }}</p>
        <div class="flex gap-4 mt-5">
            <button wire:click="decrementQuantity">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <p>{{$cantidad}}</p>
            <button wire:click="incrementQuantity">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>

        <button
            class="bg-indigo-500 hover:bg-indigo-800 px-5 py-2 mt-5 text-white font-bold uppercase rounded"
            wire:click="{{ $edit ? 'editProduct' : 'addProduct' }}"
        >
            {{ $edit ? 'Editar Producto' : 'Añadir al Pedido' }}
        </button>


    </div>
</div>

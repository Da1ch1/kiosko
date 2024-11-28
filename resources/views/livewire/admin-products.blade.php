<div>
    <h1>Products</h1>
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($this->products as $product )
                <div wire:key="{{$product->id}}" class="border p-3 shadow bg-white">
                    <img src="/img/{{$product->imagen}}.jpg" alt="imagen{{$product->nombre}}" class="w-full"/>
                    <div class="p-5">
                        <h3 class="text-2xl font-bold">{{$product->nombre}}</h3>
                        <p class="mt-5 font-black text-4xl text-amber-500">${{number_format($product->precio, 2)}}</p>
                        @if ($product->disponible)
                        <button
                            wire:click="productOutOfStock({{$product->id}})"
                            class="bg-indigo-600 rounded-md hover:bg-indigo-800 text-white uppercase w-full mt-5 p-3 font-bold"
                        > Marcar como Agotado</button>
                        @else
                        <button
                            wire:click="productAvailable({{$product->id}})"
                            class="bg-green-600 rounded-md hover:bg-green-800 text-white uppercase w-full mt-5 p-3 font-bold"
                        > Marcar como Disponible</button>
                        @endif
                    </div>
                </div>
        @empty

        @endforelse
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('productOutOfStock', () => {
        Swal.fire({
            title: 'Se marco el producto como agotado!',
            icon: "success",
            timer: 1500
        });
       });
       Livewire.on('productAvailable', () => {
        Swal.fire({
            title: 'Se marco el producto como disponible!',
            icon: "success",
            timer: 1500
        });
       });
    });
</script>

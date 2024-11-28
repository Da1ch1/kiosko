<div class="grid grid-cols-2 gap-3">
    @forelse ($this->pedidos as $pedido)
        <div wire:key="{{ $pedido->id }}"
            class="p-5 bg-white shadow space-y-2 border-b"
        >
            <p class="text-xl font-bold text-slate-600">Contenido del Pedido:</p>
            @forelse ($pedido->productos as $producto)

                <div
                    wire:key="{{ $producto->id }}"
                    class="border-b border-b-slate-200 last-of-type:border-none py-4"
                >
                    <p class="text-sm">ID: {{$producto->id}}</p>
                    <p class="text-sm">{{$producto->nombre}}</p>
                    <p>
                    Cantidad:
                    <span class="font-bold">{{$producto->pivot->cantidad}}</span>
                    </p>
                </div>
            @empty
                <p class="text-sm">Este Pedido no tiene Productos</p>
            @endforelse
            <p class="text-ls font-bold text-slate-600">Cliente:
                <span class="font-normal">{{$pedido->user->name}}</span>
            </p>
            <p class="text-ls font-bold text-amber-500">Total a Pagar:
                <span class="font-normal text-slate-500">${{ number_format($pedido->total, 2)}}</span>
            </p>
            <button
                wire:click="completar({{$pedido->id}})"
                type="button"
                class='bg-indigo-600 hover:bg-indigo-800 px-5 py-2 rounded uppercase font-bold text-white text-center w-full cursor-pointer'
            >
            Completar
            </button>
        </div>
    @empty
            <p class="text-center">No hay Ordenes aún</p>
    @endforelse
</div>
<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('ordenCompletada', () => {
        Swal.fire({
            title: 'La orden se Completo!',
            icon: "success",
            timer: 1500
        });
       });
    });
</script>


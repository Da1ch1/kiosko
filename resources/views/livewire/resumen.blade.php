<aside class="w-72 h-screen overflow-y-scroll p-5">
    <h1 class="text-4xl font-black">Mi Pedido</h1>
    <p class="text-lg my-5">Aquí podrás ver el resumen y totales de tu pedido</p>
    <div class="py-10">
    @forelse ($this->pedidos as $pedido)
        <div wire:key="{{ $pedido['id'] }}" class="shadow space-y-1 p-4 bg-white">
            <div class="space-y-2">
              <p class="text-xl font-bold">{{$pedido['nombre']}}</p>
              <p class="text-lg font-bold ">Cantidad: {{$pedido['cantidad']}}</p>
              <p class="text-lg font-bold text-amber-500">
                Precio: ${{ number_format($pedido['precio'], 2) }}
              </p>
              <p class="text-lg text-gray-700">
                Subtotal: ${{ number_format($pedido['precio'] * $pedido['cantidad'] , 2) }}
              </p>
            </div>

            <div class="flex justify-between gap-2 pb-4">
              <button
                type="button"
                class="bg-sky-700 p-2 text-white rounded-md font-bold uppercase shadow-md text-center"
                wire:click="$dispatch('openModal', {component: 'modal', arguments: {producto: {{$pedido}}, edit: true,  }})"
                >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
              </button>
              <button
                type="button"
                class="bg-red-700 p-2 text-white rounded-md font-bold uppercase shadow-md text-center"
                wire:click="eliminarProducto({{$pedido['id']}})"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  strokeWidth={2}
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </button>
            </div>
          </div>
     @empty
            <p class="text-center text-2xl">
                No hay Elementos en tu pedido aún
            </p>
     @endforelse
    </div>


    <p class="text-xl mt-10">
        Total: $ {{$this->total}}
    </p>

    @auth
        <div class="w-full mt-5">
            @if (!$this->isPedido())
                <button
                wire:click="confirmPedido"
                class="bg-indigo-600 hover:bg-indigo-800 text-white rounded-md text-center cursor-pointer w-full py-3 font-bold uppercase px-5"
            >Confirmar Pedido</button>
            @else
            <p class="p-2 bg-amber-400  rounded-md w-full font-extrabold uppercase flex justify-around">Carrito Vacio
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                </svg>
            </p>
            @endif
        </div>
    @endauth
    @guest
        <p class="p-2 bg-amber-400  rounded-md text-center mt-5 w-full font-extrabold uppercase flex justify-around">
            Inicia Sesión para poder realizar el Pedido
        </p>
        <a class="block mt-3  text-center text-gray-600 hover:text-gray-900 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Iniciar Sesión') }}
        </a>
    @endguest


</aside>
<script>
    document.addEventListener('livewire:init', () => {

       Livewire.on('alertaAgregado', () => {
        Swal.fire({
            title: 'Este producto ya se encuentra en el Carrito',
            icon: "info",
            timer: 1500
        });
       });

       Livewire.on('productoAgregado', () => {
            Swal.fire({
                title: "Producto Agregado!",
                text: "Tu Producto se a Agregado al Carrito!",
                icon: "success",
                timer: 1500
            });
       });

       Livewire.on('productoEditado', () => {
            Swal.fire({
                title: 'Producto Editado!',
                text: 'El producto se ha editado correctamente!',
                icon: "success",
                timer: 1500
            });
       });

       Livewire.on('productoEliminado', () => {
            Swal.fire({
                title: 'Producto Eliminado!',
                text: 'El producto se ha eliminado del carrito!',
                icon: "success",
                timer: 1500

            });
       });
       Livewire.on('pedidoConfirmado', () => {
            Swal.fire({
                title: 'Pedido Confirmado',
                text: 'Tú pedido se a pasado a cocina!',
                icon: "success",
                timer: 1500

            });
       });

    });
</script>

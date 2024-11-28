<aside class="md:w-72 h-screen">
    <div class="p-4">
        <img src="/img/logo.svg" alt="Logo Imagen">
    </div>
    <div class="my-5 px-5 mx-auto">
        <a  href="{{ route('home') }}"
            wire:navigate
            class="text-center block bg-indigo-500 w-full p-3 font-bold text-white hover:bg-indigo-700 rounded-md"
        >
            Kiosko
        </a>
    </div>
    <nav class="flex flex-col p-4">
        <a wire:navogate href="{{ route('dashboard') }}"
           class="font-bold text-2xl text-center @if(request()->is('dashboard')) text-blue-500 @endif"
        >
            Ordenes
        </a>
        <a wire:navogate href="{{ route('products') }}"
           class="font-bold text-2xl text-center @if(request()->is('products')) text-blue-500 @endif"
        >
            Productos
        </a>
    </nav>

    <div class="my-5 px-5">
        <form method="POST" class="w-full text-center " action="{{ route('logout') }}">
            @csrf
            <button class="text-center bg-red-500 w-full p-3  font-bold text-white truncate hover:bg-red-600 hover:font-extrabold rounded-lg" :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>
    </div>
</aside>

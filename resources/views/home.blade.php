<x-app-layout>
            <div class="md:flex">
                @livewire('sidebar')
                <main  class='flex-1 h-screen overflow-y-scroll bg-gray-100 p-3'>
                @livewire('inicio')
                    <!-- Scripts  'poner arroba' livewire('inicio') -->
                </main>
                @livewire('resumen')
            </div>

            @livewire('wire-elements-modal')
            @livewireScripts
</x-app-layout>


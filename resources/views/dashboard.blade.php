<x-app-layout>
        <div class="md:flex">
            @livewire('admin-sidebar')
            <main class="flex-1 h-screen overflow-y-scroll bg-gray-100 p-3">
                    <div>
                        <h1 class="text-4xl font-black">Panel de Administración</h1>
                        <p class='text-2xl my-5'>
                          Administra el kiosko desde aquí.
                        </p>
                        @livewire('admin')
                    </div>
            </main>
        </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijziging Gelukt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                
                <h1 class="text-2xl font-bold text-green-600 mb-4">
                    De wijziging is doorgevoerd
                </h1>
                
                <p class="text-gray-600 mb-6">
                    U wordt over 3 seconden automatisch teruggeleid naar de gezinsallergieën pagina.
                </p>

                <!-- 3 Second Redirect Logic -->
                <meta http-equiv="refresh" content="3;url={{ route('allergieen_detail', ['gezin_id' => $gezinId]) }}">

                <div class="flex justify-center">
                    <a href="{{ route('allergieen_detail', ['gezin_id' => $gezinId]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition shadow">
                        Klik hier als u niet automatisch wordt doorverbonden
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

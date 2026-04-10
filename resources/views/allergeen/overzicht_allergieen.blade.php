<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht gezinsallergieen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Terug link bovenaan -->
                <div class="mb-6 ml-2">
                    <a href="{{ route('manager.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-bold underline">
                        &larr; Terug naar dashboard
                    </a>
                </div>

                <!-- Top Section uit wireframe -->
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h1 class="text-2xl font-bold text-green-600 underline decoration-green-600">
                        Overzicht gezinnen met allergieën
                    </h1>
                    <div class="flex items-center space-x-4">
                        <select class="border-gray-300 rounded shadow-sm py-2 px-3 focus:ring focus:ring-blue-200 text-gray-700">
                            <option value="">Selecteer Allergie</option>
                            <option value="gluten">Gluten</option>
                            <option value="lactose">Lactose</option>
                        </select>
                        <button class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded shadow">
                            Toon Gezinnen
                        </button>
                    </div>
                </div>

                <!-- Table Section uit wireframe -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="border-b border-gray-200 text-left bg-gray-50">
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Naam</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Omschrijving</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100 text-center">Volwassenen</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100 text-center">Kinderen</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100 text-center">Babys</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Vertegenwoordiger</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 text-center">Allergie Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 6; $i++)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">~~~~</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">~~~~</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-center text-gray-600">~~~~</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-center text-gray-600">~~~~</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-center text-gray-600">~~~~</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">~~~~</td>
                                <td class="py-3 px-4 text-center">
                                    <button class="text-blue-500 border border-blue-200 bg-blue-50 hover:bg-blue-100 rounded px-2 py-1 inline-flex items-center justify-center transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- Home knop rechtsonder uit wireframe -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded shadow transition">
                        Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allergieën in het gezin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Titel -->
                <h1 class="text-2xl font-bold text-green-600 underline decoration-green-600 mb-6">
                    Allergieën in het gezin
                </h1>

                <!-- Gezin Info Box -->
                <div class="border border-gray-300 rounded mb-6 w-80">
                    <div class="flex border-b border-gray-300">
                        <span class="font-bold text-gray-800 px-4 py-2 w-48 border-r border-gray-300">Gezinsnaam:</span>
                        <span class="text-gray-600 px-4 py-2">{{ $gezinInfo->Gezinsnaam }}</span>
                    </div>
                    <div class="flex border-b border-gray-300">
                        <span class="font-bold text-gray-800 px-4 py-2 w-48 border-r border-gray-300">Omschrijving:</span>
                        <span class="text-gray-600 px-4 py-2">{{ $gezinInfo->Omschrijving }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-bold text-gray-800 px-4 py-2 w-48 border-r border-gray-300">Totaal aantal Personen:</span>
                        <span class="text-gray-600 px-4 py-2">{{ $gezinInfo->TotaalAantalPersonen }}</span>
                    </div>
                </div>

                <!-- Personen Tabel -->
                <div class="overflow-x-auto mb-8">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="border-b border-gray-200 text-left bg-gray-50">
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Naam</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Type Persoon</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Gezinsrol</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-100">Allergie</th>
                                <th class="py-3 px-4 font-semibold text-gray-800 text-center">Wijzig Allergie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $persoon)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">{{ $persoon->VolledigeNaam }}</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">{{ $persoon->TypePersoon }}</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">{{ $persoon->Gezinsrol }}</td>
                                <td class="py-3 px-4 border-r border-gray-100 text-gray-600">{{ $persoon->Allergie }}</td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('allergieen_edit', ['persoon_id' => $persoon->PersoonId]) }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded px-2 py-1 inline-flex items-center justify-center transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Knoppen onderaan rechts -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('overzicht_allergieen') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded shadow transition">
                        terug
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded shadow transition">
                        home
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
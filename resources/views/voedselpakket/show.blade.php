<x-app-layout>
    <x-slot name="header">
        <h2 class="text-green-600 font-bold text-xl uppercase tracking-wider">
            Overzicht Voedselpakketten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-8 shadow-md rounded-lg">
            
            <table class="mb-10 border-collapse border border-gray-200">
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-bold bg-gray-50 text-gray-700">Naam:</td>
                    <td class="border border-gray-200 px-4 py-2 text-gray-600">{{ $gezin->Gezinsnaam }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-bold bg-gray-50 text-gray-700">Omschrijving:</td>
                    <td class="border border-gray-200 px-4 py-2 text-gray-600">{{ $gezin->GezinOmschrijving }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-bold bg-gray-50 text-gray-700">Totaal aantal Personen:</td>
                    <td class="border border-gray-200 px-4 py-2 text-gray-600">{{ $gezin->TotaalPersonen }}</td>
                </tr>
            </table>

            <div class="overflow-x-auto border border-gray-200 rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Pakketnummer</th>
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Datum samenstelling</th>
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Datum uitgifte</th>
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Aantal producten</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700">Wijzig Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pakketten as $pakket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-600 border-r border-gray-200">{{ $pakket->PakketNummer }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 border-r border-gray-200">{{ $pakket->DatumSamenstelling }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 border-r border-gray-200">{{ $pakket->DatumUitgifte ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 border-r border-gray-200 italic">{{ $pakket->Status }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 border-r border-gray-200 text-center">{{ $pakket->AantalProducten ?? 0 }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('voedselpakket.edit', $gezin->GezinId) }}" title="Bekijk details" class="text-xl">
                                            ✏️
                                        </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500 italic">
                                    Geen pakketten gevonden voor dit gezin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('voedselpakket.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                    terug
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                    home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
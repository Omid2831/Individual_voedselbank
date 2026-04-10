<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Overzicht gezinnen met voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-end mb-6">
                    <form action="{{ route('voedselpakket.index') }}" method="GET" class="flex items-center gap-4">
                        <select name="eetwens_id" class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm text-sm">
                            <option value="">Selecteer Eetwens</option>
                            @foreach($eetwensen as $wens)
                                <option value="{{ $wens->Id }}" {{ request('eetwens_id') == $wens->Id ? 'selected' : '' }}>
                                    {{ $wens->Naam }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-sm transition">
                            Toon Gezinnen
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-4 py-3 text-left">Gezinsnaam</th>
                                <th class="px-4 py-3 text-left">Omschrijving</th>
                                <th class="px-4 py-3 text-left">Volwassenen</th>
                                <th class="px-4 py-3 text-left">Kinderen</th>
                                <th class="px-4 py-3 text-left">Babys</th>
                                <th class="px-4 py-3 text-left">Vertegenwoordiger</th>
                                <th class="px-4 py-3 text-center">Voedselpakket Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-600">
                            {{-- @forelse handelt zowel de data als een lege lijst af --}}
                            @forelse($gezinnen as $gezin)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4">{{ $gezin->Gezinsnaam }}</td>
                                    <td class="px-4 py-4">{{ $gezin->Omschrijving }}</td>
                                    <td class="px-4 py-4 text-center">{{ $gezin->AantalVolwassenen }}</td>
                                    <td class="px-4 py-4 text-center">{{ $gezin->AantalKinderen }}</td>
                                    <td class="px-4 py-4 text-center">{{ $gezin->AantalBabys }}</td>
                                    <td class="px-4 py-4">{{ $gezin->Vertegenwoordiger }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('voedselpakket.show', $gezin->GezinId) }}" title="Bekijk details" class="text-xl">
                                            📦
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-400 bg-yellow-100 italic">
                                        Er zijn geen gezinnen bekent die een geselecteerde eetwens hebben.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg text-sm font-bold shadow transition">
                        home
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
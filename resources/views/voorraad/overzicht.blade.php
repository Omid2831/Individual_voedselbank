<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Productvoorraden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filter Section -->
                    <div class="mb-6 flex justify-end">
                        <form action="{{ route('voorraad.overzicht') }}" method="GET" class="flex gap-4">
                            <select name="categorie"
                                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecteer Categorie</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->Naam }}"
                                        {{ $categorie === $cat->Naam ? 'selected' : '' }}>
                                        {{ $cat->Naam }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Toon Voorraad
                            </button>
                        </form>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Productnaam</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categorie</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Eenheid</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aantal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Houdbaarheidsdatum</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Magazijn</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Voorraad Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($voorraad && $voorraad->count() > 0)
                                    @foreach ($voorraad as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->ProductNaam ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->Categorie ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->Eenheid ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->Aantal ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->Houdbaarheidsdatum ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->Magazijn ?? '~' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @php
                                                    $detailId = $item->ProductId ?? ($item->Id ?? null);
                                                    $detailName = $item->ProductNaam ?? null;
                                                @endphp
                                                @if ($detailId)
                                                    <a href="{{ route('voorraad.show', $detailId) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fa fa-pencil"></i> Details
                                                    </a>
                                                @elseif ($detailName)
                                                    <a href="{{ route('voorraad.show', urlencode($detailName)) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fa fa-pencil"></i> Details
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">Details niet beschikbaar</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Geen
                                            gegevens beschikbaar</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $voorraad->links() }}
                    </div>

                    <!-- Home Button -->
                    <div class="mt-6 flex justify-end">
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Terug naar Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Leverancier Info -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Naam:</p>
                                <p class="text-base text-gray-900">{{ $leverancier->Naam }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Leveranciernummer:</p>
                                <p class="text-base text-gray-900">{{ $leverancier->LeverancierNummer }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Leveranciertype:</p>
                                <p class="text-base text-gray-900">{{ $leverancier->LeverancierType }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Naam</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Soort Allergie</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Barcode</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Houdbaarheidsdatum</th>
                                    <th class="px-6 py-3 border-b text-center text-sm font-semibold text-gray-700">Wijzig Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $product->Naam }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $product->SoortAllergie ?? 'Geen' }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $product->Barcode }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 border-b text-center">
                                        <a href="{{ route('leverancier.product.edit', [$leverancier->Id, $product->Id]) }}" class="text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Geen producten gevonden voor deze leverancier</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('leverancier.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                            Terug
                        </a>
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                            Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

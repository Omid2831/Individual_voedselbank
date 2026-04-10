<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-6 bg-white">
                    <h3 class="text-4xl font-semibold text-green-600 mb-6 underline decoration-1">
                        Product Details {{ $product->Productnaam ?? ($product->ProductNaam ?? '~') }}
                    </h3>

                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800 w-1/2">Productnaam</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">
                                    {{ $product->Productnaam ?? ($product->ProductNaam ?? '~') }}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Houdbaarheidsdatum</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">
                                    {{ $product->HoudbaarheidsdatumFormatted ?? '~' }}
                                </td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Barcode</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">{{ $product->Barcode ?? '~' }}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Magazijn locatie</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">
                                    {{ $product->MagazijnLocatie ?? ($product->Magazijn ?? '~') }}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Ontvangstdatum</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">
                                    {{ $product->OntvangstdatumFormatted ?? '~' }}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Uitleveringsdatum</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">
                                    {{ $product->UitleveringsdatumFormatted ?? '~' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-bold text-2xl text-gray-800">Aantal op voorraad</td>
                                <td class="px-4 py-3 text-2xl text-gray-800">{{ $product->Aantal ?? '~' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-8 flex justify-between items-center gap-4">
                        @php
                            $editId = $product->ProductId ?? ($product->Id ?? ($product->ProductNaam ?? null));
                        @endphp
                        @if (Route::has('voorraad.edit') && $editId)
                            <a href="{{ route('voorraad.edit', $editId) }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                Wijzig
                            </a>
                        @else
                            <span class="px-6 py-2 bg-gray-300 text-gray-600 rounded-md text-xl cursor-not-allowed">
                                Wijzig
                            </span>
                        @endif
                        <div class="flex justify-end gap-3">

                            <a href="{{ route('voorraad.overzicht') }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                terug
                            </a>
                            <a href="{{ url('/dashboard') }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 bg-white">
                    <h3 class="text-4xl font-semibold text-green-600 mb-8 underline decoration-1">
                        Wijzig Product Details {{ $product->Productnaam ?? ($product->ProductNaam ?? '~') }}
                    </h3>

                    @if (session('success'))
                        <div
                            class="mb-8 rounded-lg border border-emerald-200 bg-emerald-100 px-4 py-3 text-emerald-900 text-2xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-8 rounded-lg border border-red-200 bg-red-100 px-4 py-3 text-red-900 text-2xl">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('voorraad.update', $product->Id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 items-center">
                            <label class="font-bold text-2xl text-gray-800">Productnaam</label>
                            <input type="text" readonly
                                value="{{ $product->Productnaam ?? ($product->ProductNaam ?? '~') }}"
                                class="w-full rounded-md border border-slate-200 bg-slate-100 text-2xl text-gray-700" />

                            <label class="font-bold text-2xl text-gray-800">Houdbaarheidsdatum</label>
                            <input type="text" readonly value="{{ $product->HoudbaarheidsdatumFormatted ?? '~' }}"
                                class="w-full rounded-md border border-slate-200 bg-slate-100 text-2xl text-gray-700" />

                            <label class="font-bold text-2xl text-gray-800">Barcode</label>
                            <input type="text" readonly value="{{ $product->Barcode ?? '~' }}"
                                class="w-full rounded-md border border-slate-200 bg-slate-100 text-2xl text-gray-700" />

                            <label for="magazijn_locatie" class="font-bold text-2xl text-gray-800">Magazijn
                                Locatie</label>
                            <select id="magazijn_locatie" name="magazijn_locatie"
                                class="w-full rounded-md border border-slate-300 bg-white text-2xl text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                                @php
                                    $currentLocatie = old(
                                        'magazijn_locatie',
                                        $product->MagazijnLocatie ?? ($product->Magazijn ?? ''),
                                    );
                                @endphp
                                @foreach ($locaties as $locatie)
                                    <option value="{{ $locatie }}"
                                        {{ $currentLocatie === $locatie ? 'selected' : '' }}>
                                        {{ $locatie }}
                                    </option>
                                @endforeach
                            </select>

                            <label class="font-bold text-2xl text-gray-800">Ontvangstdatum</label>
                            <input type="text" readonly value="{{ $product->OntvangstdatumFormatted ?? '~' }}"
                                class="w-full rounded-md border border-slate-200 bg-slate-100 text-2xl text-gray-700" />

                            <label for="aantal_uitgeleverd" class="font-bold text-2xl text-gray-800">Aantal uitgeleverde
                                producten:</label>
                            <div>
                                <input id="aantal_uitgeleverd" name="aantal_uitgeleverd" type="number" min="0"
                                    value="{{ old('aantal_uitgeleverd') }}"
                                    class="w-full rounded-md border border-slate-300 bg-white text-2xl text-gray-700 focus:border-blue-500 focus:ring-blue-500" />
                                @if (session('business_error'))
                                    <p class="mt-2 text-lg text-red-500">{{ session('business_error') }}</p>
                                @endif
                            </div>

                            <label for="uitleveringsdatum"
                                class="font-bold text-2xl text-gray-800">Uitleveringsdatum</label>
                            <input id="uitleveringsdatum" name="uitleveringsdatum" type="date"
                                value="{{ old('uitleveringsdatum', $product->Uitleveringsdatum ?? '') }}"
                                class="w-full rounded-md border border-slate-300 bg-white text-2xl text-gray-700 focus:border-blue-500 focus:ring-blue-500" />

                            <label class="font-bold text-2xl text-gray-800">Aantal op voorraad</label>
                            <input type="text" readonly value="{{ $product->Aantal ?? '~' }}"
                                class="w-full rounded-md border border-slate-200 bg-slate-100 text-2xl text-gray-700" />
                        </div>

                        <div class="pt-2 flex justify-between items-center gap-4">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                Wijzig Product Details
                            </button>

                            <div class="flex justify-end gap-3">
                                <a href="{{ route('voorraad.show', $product->Id) }}"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                    terug
                                </a>
                                <a href="{{ url('/dashboard') }}"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xl">
                                    home
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

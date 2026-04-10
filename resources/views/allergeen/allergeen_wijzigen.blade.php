<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allergie Wijzigen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- High Risk Warning -->
                @if($showWarning)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Let op!</strong>
                    <span class="block sm:inline">Voor het wijzigen van deze allergie wordt geadviseerd eerst een arts te raadplegen vanwege een hoog risico op een anafylactisch shock.</span>
                </div>
                @endif

                <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">
                    Allergie wijzigen voor: <span class="text-blue-600">{{ $persoonAllergie->VolledigeNaam }}</span>
                </h1>

                <form method="POST" action="{{ route('allergieen_update', ['persoon_id' => $persoonAllergie->PersoonId]) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Huidige Allergie:</label>
                        <p class="text-gray-900 bg-gray-100 p-2 rounded shadow-sm inline-block">{{ $persoonAllergie->HuidigeAllergieNaam ?? 'Onbekend' }}</p>
                    </div>

                    <div class="mb-6">
                        <label for="allergie_id" class="block text-gray-700 text-sm font-bold mb-2">Nieuwe Allergie Selecteren:</label>
                        <select name="allergie_id" id="allergie_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline max-w-sm">
                            <option value="">-- Selecteer een nieuwe allergie --</option>
                            @foreach($allAllergies as $allergie)
                                <option value="{{ $allergie->Id }}" {{ (isset($persoonAllergie->HuidigeAllergieId) && $allergie->Id == $persoonAllergie->HuidigeAllergieId) ? 'selected' : '' }}>
                                    {{ $allergie->Naam }}
                                </option>
                            @endforeach
                        </select>
                        @error('allergie_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition shadow">
                            Wijzig Allergie
                        </button>
                        <a href="{{ url()->previous() }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                            Annuleren
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }} <br>
                    {{ 'This is the manager page' }}
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('voorraad.overzicht') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Overzicht Productvoorraden
                    </a>
                    <h3 class="text-2xl font-bold mb-4">Homepage voedselbank maaskantje</h3>
                    <a href="{{ route('leverancier.index') }}" class="text-blue-600 hover:text-blue-800 underline text-lg">
                        Overzicht Leveranciers
                    </a>
                    <div class="mb-4 ml-4">
                        <a href="{{ route('overzicht_allergieen') }}" class="text-blue-600 hover:text-blue-800 font-bold underline text-lg">
                            &rarr; Overzicht gezinsallergieën
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->role === 'medewerker')
                        <h3 class="text-2xl font-bold mb-4">Homepage voedselbank maaskantje</h3>
                        <a href="{{ route('leverancier.index') }}" class="text-blue-600 hover:text-blue-800 underline text-lg">
                            Overzicht Leveranciers
                        </a>
                    @else
                        {{ __("You're logged in!") }} <br>
                        {{ "This is the admin page" }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

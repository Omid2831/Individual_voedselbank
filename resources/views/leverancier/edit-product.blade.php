<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                        <p class="font-medium">{{ session('error') }}</p>
                        <p class="text-sm mt-1">De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd</p>
                    </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('leverancier.product.update', [$leverancier->Id, $product->Id]) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="houdbaarheidsdatum" class="block text-lg font-semibold text-gray-700 mb-2">
                                Houdbaarheidsdatum:
                            </label>
                            <input 
                                type="date" 
                                id="houdbaarheidsdatum" 
                                name="houdbaarheidsdatum" 
                                value="{{ old('houdbaarheidsdatum', \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                            @error('houdbaarheidsdatum')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between items-center">
                            <button 
                                type="submit" 
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-8 py-3 rounded-lg transition duration-200"
                            >
                                Wijzig Houdbaarheidsdatum
                            </button>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('leverancier.products', $leverancier->Id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">
                                    Terug
                                </a>
                                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">
                                    Home
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

    <x-app-layout>
        <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-100">
            
            <div class="max-w-2xl mx-auto w-full">
                <div class="bg-white p-8 shadow-lg rounded-lg border border-gray-200">
                    
                    <h2 class="text-green-600 font-bold text-2xl mb-6 text-center italic">
                        Wijzig status voedselpakket
                    </h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow-sm text-center font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('voedselpakket.update', $pakket->PakketId) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-8">
                            <label for="status" class="block font-bold text-gray-700 mb-2 text-center">
                                Selecteer nieuwe status:
                            </label>
                            <select name="status" id="status" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-center py-3">
                                <option value="NietUitgereikt">
                                    Niet Uitgereikt
                                </option>
                                <option value="Uitgereikt">
                                    Uitgereikt
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col items-center gap-6">
                            <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded shadow-md transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                Wijzig status voedselpakket
                                >
                                Wijzig status voedselpakket
                            </button>
                            
                            <a href="{{ route('voedselpakket.show', $pakket->PakketId) }}" 
                            class="text-blue-600 hover:text-blue-800 font-bold transition underline decoration-2 underline-offset-4">
                                terug naar overzicht
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </x-app-layout>
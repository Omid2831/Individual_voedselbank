<x-app-layout>
    <div class="min-h-screen flex flex-col justify-center py-12 bg-gray-100">
        <div class="max-w-2xl mx-auto w-full">
            <div class="bg-white p-8 shadow-lg rounded-lg border border-gray-200">
                
                <h2 class="text-green-600 font-bold text-2xl mb-6 text-center italic">
                    Wijzig status voedselpakket
                </h2>

                @if($pakket->Status === 'NietMeerIngeschreven')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center font-bold">
                        Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center font-bold">
                        {{ session('error') }}
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
                            {{ $pakket->Status == 'NietMeerIngeschreven' ? 'disabled' : '' }}
                            class="w-full border-gray-300 rounded-md shadow-sm text-center py-3 {{ $pakket->Status == 'NietMeerIngeschreven' ? 'bg-gray-100' : '' }}">
                            
                            <option value="Niet Uitgereikt" {{ $pakket->Status == 'Niet Uitgereikt' ? 'selected' : '' }}>
                                Niet Uitgereikt
                            </option>
                            <option value="Uitgereikt" {{ $pakket->Status == 'Uitgereikt' ? 'selected' : '' }}>
                                Uitgereikt
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col items-center gap-6">
                        <button type="submit" 
                            {{ $pakket->Status == 'NietMeerIngeschreven' ? 'disabled' : '' }}
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded shadow-md transition {{ $pakket->Status == 'NietMeerIngeschreven' ? 'opacity-50 cursor-not-allowed bg-gray-400' : '' }}">
                            Wijzig status voedselpakket
                        </button>
                        
                        <a href="{{ route('voedselpakket.show', $pakket->GezinId) }}" 
                            class="text-blue-600 hover:text-blue-800 font-bold underline decoration-2 underline-offset-4">
                            terug naar overzicht
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
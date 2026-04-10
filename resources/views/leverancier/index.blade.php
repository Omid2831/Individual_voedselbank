<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Leveranciers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Filter Section -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-end items-start sm:items-center gap-3">
                        <select id="leveranciertype" class="w-full sm:w-auto border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none cursor-pointer" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem; min-width: 250px;">
                            <option value="" selected>Selecteer LeverancierType</option>
                            <option value="Bedrijf">Bedrijf</option>
                            <option value="Instelling">Instelling</option>
                            <option value="Overheid">Overheid</option>
                            <option value="Particulier">Particulier</option>
                            <option value="Donor">Donor</option>
                        </select>
                        <button id="toonLeveranciers" class="w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200 whitespace-nowrap">
                            Toon Leveranciers
                        </button>
                    </div>

                    <!-- Warning Message -->
                    <div id="warningMessage" class="hidden mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                        <p class="font-medium">Er zijn geen leveranciers bekend van het geselecteerde leverancierstype</p>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Naam</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Contactpersoon</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Mobiel</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Leveranciernummer</th>
                                    <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">LeverancierType</th>
                                    <th class="px-6 py-3 border-b text-center text-sm font-semibold text-gray-700">Product Details</th>
                                </tr>
                            </thead>
                            <tbody id="leverancierTable">
                                @forelse($leveranciers as $leverancier)
                                <tr class="hover:bg-gray-50 leverancier-row" data-type="{{ $leverancier->LeverancierType }}"
                                    data-id="{{ $leverancier->Id }}"
                                    data-naam="{{ $leverancier->Naam }}"
                                    data-contactpersoon="{{ $leverancier->ContactPersoon }}"
                                    data-email="{{ $leverancier->Email ?? 'N/A' }}"
                                    data-mobiel="{{ $leverancier->Mobiel ?? 'N/A' }}"
                                    data-leveranciernummer="{{ $leverancier->LeverancierNummer }}"
                                    data-leveranciertype="{{ $leverancier->LeverancierType }}"
                                    data-straat="{{ $leverancier->Straat ?? 'N/A' }}"
                                    data-huisnummer="{{ $leverancier->Huisnummer ?? '' }}"
                                    data-toevoeging="{{ $leverancier->Toevoeging ?? '' }}"
                                    data-postcode="{{ $leverancier->Postcode ?? 'N/A' }}"
                                    data-woonplaats="{{ $leverancier->Woonplaats ?? 'N/A' }}"
                                    data-opmerking="{{ $leverancier->Opmerking ?? 'Geen opmerking' }}"
                                    data-datumaangemaakt="{{ $leverancier->DatumAangemaakt ?? 'N/A' }}"
                                    data-datumgewijzigd="{{ $leverancier->DatumGewijzigd ?? 'N/A' }}">
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $leverancier->Naam }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $leverancier->ContactPersoon }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $leverancier->Email ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800 whitespace-nowrap">
                                        @if($leverancier->Mobiel)
                                            {{ preg_replace('/(\+31)\s*(\d{1})(\d{8})/', '$1 $2 $3', $leverancier->Mobiel) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $leverancier->LeverancierNummer }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $leverancier->LeverancierType }}</td>
                                    <td class="px-6 py-4 border-b text-center">
                                        <a href="{{ route('leverancier.products', $leverancier->Id) }}" class="text-blue-600 hover:text-blue-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Geen leveranciers gevonden</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Home Button -->
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                            Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Product Details -->
    <div id="detailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900">Leverancier Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>
            </div>
            
            <div class="mt-4 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Naam:</p>
                        <p id="modal-naam" class="text-base text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Contactpersoon:</p>
                        <p id="modal-contactpersoon" class="text-base text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Email:</p>
                        <p id="modal-email" class="text-base text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Mobiel:</p>
                        <p id="modal-mobiel" class="text-base text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Leveranciernummer:</p>
                        <p id="modal-leveranciernummer" class="text-base text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-600">LeverancierType:</p>
                        <p id="modal-leveranciertype" class="text-base text-gray-900"></p>
                    </div>
                </div>
                
                <div class="border-t pt-3 mt-3">
                    <p class="text-sm font-semibold text-gray-600 mb-2">Adres:</p>
                    <p id="modal-adres" class="text-base text-gray-900"></p>
                </div>
                
                <div class="border-t pt-3">
                    <p class="text-sm font-semibold text-gray-600">Opmerking:</p>
                    <p id="modal-opmerking" class="text-base text-gray-900"></p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg">
                    Sluiten
                </button>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        function filterLeveranciers() {
            const selectedType = document.getElementById('leveranciertype').value;
            const rows = document.querySelectorAll('.leverancier-row');
            const warningMessage = document.getElementById('warningMessage');
            let visibleCount = 0;
            let hasValidEmailCount = 0;
            
            rows.forEach(row => {
                if (selectedType === '' || selectedType === 'Selecteer LeverancierType' || row.dataset.type === selectedType) {
                    const email = row.dataset.email;
                    
                    // Only show rows with valid email (not N/A)
                    if (email !== 'N/A' && email !== '') {
                        row.style.display = '';
                        visibleCount++;
                        hasValidEmailCount++;
                    } else if (selectedType === '' || selectedType === 'Selecteer LeverancierType') {
                        // Show all when no filter selected
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        // Hide rows without email when filtering
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show warning if selected type has no leveranciers with valid email
            if (selectedType !== '' && selectedType !== 'Selecteer LeverancierType' && hasValidEmailCount === 0) {
                warningMessage.classList.remove('hidden');
            } else {
                warningMessage.classList.add('hidden');
            }
        }
        
        // Filter only on button click
        document.getElementById('toonLeveranciers').addEventListener('click', filterLeveranciers);
        
        // Show details modal
        function showDetails(button) {
            const row = button.closest('tr');
            
            // Populate modal with data
            document.getElementById('modal-naam').textContent = row.dataset.naam;
            document.getElementById('modal-contactpersoon').textContent = row.dataset.contactpersoon;
            document.getElementById('modal-email').textContent = row.dataset.email;
            document.getElementById('modal-mobiel').textContent = row.dataset.mobiel;
            document.getElementById('modal-leveranciernummer').textContent = row.dataset.leveranciernummer;
            document.getElementById('modal-leveranciertype').textContent = row.dataset.leveranciertype;
            document.getElementById('modal-opmerking').textContent = row.dataset.opmerking;
            
            // Build address string
            let adres = row.dataset.straat + ' ' + row.dataset.huisnummer;
            if (row.dataset.toevoeging) {
                adres += ' ' + row.dataset.toevoeging;
            }
            adres += ', ' + row.dataset.postcode + ' ' + row.dataset.woonplaats;
            document.getElementById('modal-adres').textContent = adres;
            
            // Show modal
            document.getElementById('detailsModal').classList.remove('hidden');
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\VoorraadModel;

class VoorraadController extends Controller
{
    private $voorraadModel;
    public function __construct()
    {
        $this->voorraadModel = new VoorraadModel();
    }

    public function overzicht(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = 10;
            $categorie = $request->get('categorie', '');

            // Get categories for dropdown
            $categories = DB::table('Categorie')->select('Id', 'Naam')->get();

            // Get paginated voorraad from model
            $voorraadModel = new VoorraadModel();
            $voorraad = $voorraadModel->getPaginatedVoorraad($page, $perPage, $categorie, $request);

            return view('voorraad.overzicht', compact('voorraad', 'categories', 'categorie'));
        } catch (\Exception $e) {
            Log::error('Fout bij weergave van voorraadoverzicht: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Er is een fout opgetreden bij het laden van de voorraad');
        }
    }

    /**
     * Show detailed product information
     * 
     * @param string $name - Product Name
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $product = null;

            if (is_numeric($id)) {
                $product = $this->voorraadModel->getProductById((int) $id);
            }

            if ($product === null) {
                $product = $this->voorraadModel->getProductByName($id);

                // When route parameter is a name, enrich with full detail payload by id.
                if ($product !== null) {
                    $resolvedId = $product->ProductId ?? ($product->Id ?? null);
                    if ($resolvedId) {
                        $fullProduct = $this->voorraadModel->getProductById((int) $resolvedId);
                        if ($fullProduct !== null) {
                            $product = $fullProduct;
                        }
                    }
                }
            }

            if ($product === null) {
                Log::warning('Poging tot weergave van non-existent product - ID/Naam: ' . $id);
                return redirect()->route('voorraad.overzicht')
                    ->with('error', 'Product niet gevonden');
            }

            Log::info('Productdetailpagina weergegeven - Product ID/Naam: ' . $id);
            return view('voorraad.show', compact('product'));
        } catch (\Exception $e) {
            Log::error('Fout bij weergave van productdetails: ' . $e->getMessage());
            return redirect()->route('voorraad.overzicht')
                ->with('error', 'Er is een fout opgetreden bij het laden van het product');
        }
    }

    /**
     * Show edit page for voorraad details
     */
    public function edit($id)
    {
        try {
            $product = null;

            if (is_numeric($id)) {
                $product = $this->voorraadModel->getProductById((int) $id);
            }

            if ($product === null) {
                $product = $this->voorraadModel->getProductByName($id);
            }


            $identifier = $product->ProductId ?? ($product->Id ?? ($product->ProductNaam ?? $id));

            $locaties = $this->voorraadModel->getMagazijnLocaties();

            return view('voorraad.edit', compact('product', 'locaties', 'identifier'));
        } catch (\Exception $e) {
            Log::error('Fout bij laden van wijzigpagina: ' . $e->getMessage());
            return redirect()->route('voorraad.overzicht')
                ->with('error', 'Er is een fout opgetreden bij het laden van de wijzigpagina');
        }
    }

    /**
     * Update voorraad details
     */
    public function update(Request $request, $id)
    {
        $payload = [
            'magazijn_locatie' => $request->input('magazijn_locatie'),
            'aantal_uitgeleverd' => $request->input('aantal_uitgeleverd'),
            'uitleveringsdatum' => $request->input('uitleveringsdatum'),
        ];

        $result = $this->voorraadModel->updateProductVoorraadDetails($id, $payload);

        if (!$result['success']) {
            return redirect()->route('voorraad.edit', $id)
                ->withInput()
                ->with('error', 'De productgegevens kunnen niet worden gewijzigd')
                ->with('business_error', $result['message']);
        }

        return redirect()->route('voorraad.edit', $id)
            ->with('success', $result['message']);
    }
}

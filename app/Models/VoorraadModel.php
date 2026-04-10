<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VoorraadModel extends Model
{
    /**
     * Get all voorraad data from stored procedure
     * @return array|null
     */
    public function getAllVoorraad()
    {
        try {
            // Call the stored procedure to get the voorraad data
            $voorraadData = DB::select('CALL sp_getAllVoorraad()');
            Log::info('Voorraadgegevens succesvol opgehaald');
            return $voorraadData;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Fout bij het ophalen van voorraadgegevens: ' . $e->getMessage());
        }
    }

    /**
     * Get detailed product information by product name
     * @param string $productName
     * @return array|null
     */
    public function getProductByName($productName)
    {
        try {
            // Validate product name
            if (empty($productName)) {
                throw new \Exception('Productnaam is leeg');
            }
            // Decode URL-encoded product name
            $productName = urldecode($productName);

            // Get product from getAllVoorraad and find by name
            $allProducts = DB::select('CALL sp_getAllVoorraad()');

            foreach ($allProducts as $product) {
                if ($product->ProductNaam === $productName) {
                    Log::info('Productdetails succesvol opgehaald - Product: ' . $productName);
                    return $product;
                }
            }

            Log::warning('Product niet gevonden - Naam: ' . $productName);
        ;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Fout bij het ophalen van productdetails (Naam: ' . $productName . '): ' . $e->getMessage());

        }
    }

    /**
     * Get paginated voorraad with optional category filter
     * @param int $page
     * @param int $perPage
     * @param string $categorie
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedVoorraad($page = 1, $perPage = 10, $categorie = '', $request = null)
    {
        try {
            // Get all voorraad from stored procedure
            $allVoorraad = $this->getAllVoorraad();

            if ($allVoorraad === null) {
                throw new \Exception('Kon voorraadgegevens niet ophalen');
            }

            // Filter by category if selected
            if ($categorie) {
                $allVoorraad = array_filter($allVoorraad, function ($item) use ($categorie) {
                    return $item->Categorie === $categorie;
                });
                $allVoorraad = array_values($allVoorraad);
            }

            // Create paginator
            $paginator = new LengthAwarePaginator(
                collect($allVoorraad)->forPage($page, $perPage)->values(),
                count($allVoorraad),
                $perPage,
                $page,
                [
                    'path' => $request ? $request->url() : '',
                    'query' => $request ? $request->query() : '',
                ]
            );

            Log::info('Gepagineerde voorraadgegevens opgehaald - Pagina: ' . $page . ', Categorie: ' . ($categorie ?: 'Alle'));
            return $paginator;
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van gepagineerde voorraadgegevens: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
}
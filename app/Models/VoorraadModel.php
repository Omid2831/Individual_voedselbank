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
                    if (!isset($product->ProductId) || empty($product->ProductId)) {
                        $resolvedId = DB::table('Product')
                            ->where('Naam', $productName)
                            ->value('Id');

                        if ($resolvedId) {
                            $product->ProductId = (int) $resolvedId;
                        }
                    }

                    Log::info('Productdetails succesvol opgehaald - Product: ' . $productName);
                    return $product;
                }
            }

            Log::warning('Product niet gevonden - Naam: ' . $productName);;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Fout bij het ophalen van productdetails (Naam: ' . $productName . '): ' . $e->getMessage());
        }
    }

    /**
     * Get detailed product information by product id
     * @param int $productId
     * @return object|null
     */
    public function getProductById($productId)
    {
        try {
            if (empty($productId) || !is_numeric($productId)) {
                throw new \InvalidArgumentException('Ongeldig product id');
            }

            $result = DB::select('CALL sp_getProductDetails(?)', [(int) $productId]);

            if (empty($result)) {
                Log::warning('Product niet gevonden op id', ['product_id' => $productId]);
                return null;
            }

            return $result[0];
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen productdetails op id', [
                'product_id' => $productId,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get distinct magazijn locaties for dropdown
     * @return array
     */
    public function getMagazijnLocaties()
    {
        try {
            return DB::table('ProductPerMagazijn')
                ->select('Locatie')
                ->distinct()
                ->orderBy('Locatie')
                ->pluck('Locatie')
                ->toArray();
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen magazijnlocaties', ['message' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Update product voorraad details with business validation
     * @param int|string $productIdentifier
     * @param array $payload
     * @return array{success: bool, message: string}
     */
    public function updateProductVoorraadDetails($productIdentifier, array $payload)
    {
        try {
            $product = is_numeric($productIdentifier)
                ? $this->getProductById((int) $productIdentifier)
                : $this->getProductByName($productIdentifier);

            if ($product === null) {
                return [
                    'success' => false,
                    'message' => 'Product niet gevonden',
                ];
            }

            $productId = $product->ProductId ?? ($product->Id ?? null);

            if (!$productId && isset($product->ProductNaam)) {
                $productId = DB::table('Product')
                    ->where('Naam', $product->ProductNaam)
                    ->value('Id');
            }

            if (!$productId) {
                return [
                    'success' => false,
                    'message' => 'Product id ontbreekt',
                ];
            }

            $aantalUitgeleverd = isset($payload['aantal_uitgeleverd']) ? (int) $payload['aantal_uitgeleverd'] : -1;
            $uitleveringsdatum = $payload['uitleveringsdatum'] ?? null;
            $magazijnLocatie = $payload['magazijn_locatie'] ?? ($product->MagazijnLocatie ?? ($product->Magazijn ?? null));
            $huidigeVoorraad = (int) ($product->Aantal ?? 0);

            if ($aantalUitgeleverd < 0) {
                return [
                    'success' => false,
                    'message' => 'Aantal uitgeleverde producten moet 0 of hoger zijn',
                ];
            }

            if ($aantalUitgeleverd > $huidigeVoorraad) {
                return [
                    'success' => false,
                    'message' => 'Er worden meer producten uitgeleverd dan er in voorraad zijn',
                ];
            }

            $nieuwAantal = $huidigeVoorraad - $aantalUitgeleverd;

            DB::statement('CALL sp_updateProductVoorraadDetails(?, ?, ?, ?)', [
                (int) $productId,
                $magazijnLocatie,
                $uitleveringsdatum,
                $nieuwAantal,
            ]);

            return [
                'success' => true,
                'message' => 'De productgegevens zijn gewijzigd',
            ];
        } catch (\Exception $e) {
            Log::error('Technische fout bij bijwerken product voorraadgegevens', [
                'product_identifier' => $productIdentifier,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'De productgegevens kunnen niet worden gewijzigd',
            ];
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

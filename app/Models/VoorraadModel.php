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

            $result = [];
            try {
                $result = DB::select('CALL sp_getProductDetails(?)', [(int) $productId]);
            } catch (\Exception $e) {
                // Fall back to direct query if stored procedure is outdated or missing fields.
                Log::warning('sp_getProductDetails fallback geactiveerd', [
                    'product_id' => $productId,
                    'message' => $e->getMessage(),
                ]);
            }

            if (!empty($result)) {
                $product = $result[0];
            } else {
                $product = DB::table('Product as p')
                    ->leftJoin('ProductPerMagazijn as ppm', 'p.Id', '=', 'ppm.ProductId')
                    ->leftJoin('Magazijn as m', 'ppm.MagazijnId', '=', 'm.Id')
                    ->where('p.Id', (int) $productId)
                    ->selectRaw(
                        "p.Id, p.Id as ProductId, p.Naam as ProductNaam, p.Naam as Productnaam, p.Barcode, " .
                        "DATE_FORMAT(p.Houdbaarheidsdatum, '%d-%m-%Y') as HoudbaarheidsdatumFormatted, " .
                        "DATE_FORMAT(m.Ontvangstdatum, '%d-%m-%Y') as OntvangstdatumFormatted, " .
                        "DATE_FORMAT(m.Uitleveringsdatum, '%d-%m-%Y') as UitleveringsdatumFormatted, " .
                        "m.Aantal, ppm.Locatie as MagazijnLocatie"
                    )
                    ->first();

                if (!$product) {
                    Log::warning('Product niet gevonden op id', ['product_id' => $productId]);
                    return null;
                }
            }

            // Normalize property names across procedures/views.
            if (!isset($product->ProductNaam) && isset($product->Productnaam)) {
                $product->ProductNaam = $product->Productnaam;
            }
            if (!isset($product->Productnaam) && isset($product->ProductNaam)) {
                $product->Productnaam = $product->ProductNaam;
            }
            if (!isset($product->ProductId) && isset($product->Id)) {
                $product->ProductId = $product->Id;
            }

            // Backfill product-level fields when payload is partial.
            $base = DB::table('Product')
                ->where('Id', (int) $productId)
                ->first(['Id', 'Naam', 'Barcode', 'Houdbaarheidsdatum']);

            if ($base) {
                $product->Id = $product->Id ?? $base->Id;
                $product->ProductId = $product->ProductId ?? $base->Id;
                $product->ProductNaam = $product->ProductNaam ?? $base->Naam;
                $product->Productnaam = $product->Productnaam ?? $base->Naam;
                $product->Barcode = $product->Barcode ?? $base->Barcode;

                if (empty($product->HoudbaarheidsdatumFormatted) && !empty($base->Houdbaarheidsdatum)) {
                    $product->HoudbaarheidsdatumFormatted = date('d-m-Y', strtotime($base->Houdbaarheidsdatum));
                }
            }

            // Backfill magazijn dates if missing.
            $mag = DB::table('ProductPerMagazijn as ppm')
                ->join('Magazijn as m', 'ppm.MagazijnId', '=', 'm.Id')
                ->where('ppm.ProductId', (int) $productId)
                ->select('m.Ontvangstdatum', 'm.Uitleveringsdatum')
                ->first();

            if ($mag) {
                if (empty($product->OntvangstdatumFormatted) && !empty($mag->Ontvangstdatum)) {
                    $product->OntvangstdatumFormatted = date('d-m-Y', strtotime($mag->Ontvangstdatum));
                }
                if (empty($product->UitleveringsdatumFormatted) && !empty($mag->Uitleveringsdatum)) {
                    $product->UitleveringsdatumFormatted = date('d-m-Y', strtotime($mag->Uitleveringsdatum));
                }
            }

            return $product;
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

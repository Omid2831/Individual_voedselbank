<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Leverancier;
use Exception;

class LeverancierController extends Controller
{
    /* Display all active leveranciers */
    public function index()
    {
        try {
            $leveranciers = Leverancier::getAllLeveranciers();
            
            return view('leverancier.index', compact('leveranciers'));
        } catch (Exception $e) {
            Log::error('Error fetching leveranciers: ' . $e->getMessage());
            
            return redirect()
                ->route('dashboard')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de leveranciers.');
        }
    }
    
    /* Display products for a specific leverancier */
    public function products($id)
    {
        try {
            // Get leverancier details
            $leverancier = Leverancier::getLeverancierById($id);
            
            if (!$leverancier) {
                Log::warning('Leverancier not found with ID: ' . $id);
                return redirect()
                    ->route('leverancier.index')
                    ->with('error', 'Leverancier niet gevonden');
            }
            
            Log::info('Found leverancier: ' . $leverancier->Naam);
            
            // Get products for this leverancier
            $products = Leverancier::getProductsByLeverancier($id);
            
            Log::info('Found ' . count($products) . ' products');
            
            return view('leverancier.products', compact('leverancier', 'products'));
        } catch (Exception $e) {
            Log::error('Error fetching products for leverancier ' . $id . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de producten: ' . $e->getMessage());
        }
    }
    
    /* Show form to edit product expiry date */
    public function editProduct($leverancierId, $productId)
    {
        try {
            // Get leverancier details
            $leveranciers = Leverancier::getAllLeveranciers();
            $leverancier = collect($leveranciers)->firstWhere('Id', $leverancierId);
            
            if (!$leverancier) {
                return redirect()
                    ->route('leverancier.index')
                    ->with('error', 'Leverancier niet gevonden');
            }
            
            // Get product details
            $products = Leverancier::getProductsByLeverancier($leverancierId);
            $product = collect($products)->firstWhere('Id', $productId);
            
            if (!$product) {
                return redirect()
                    ->route('leverancier.products', $leverancierId)
                    ->with('error', 'Product niet gevonden');
            }
            
            return view('leverancier.edit-product', compact('leverancier', 'product'));
        } catch (Exception $e) {
            Log::error('Error loading edit form for product ' . $productId . ': ' . $e->getMessage());
            
            return redirect()
                ->route('leverancier.products', $leverancierId)
                ->with('error', 'Er is een fout opgetreden bij het laden van het product.');
        }
    }
    
    /* Update product expiry date with validation (max 7 days extension) */
    public function updateProduct(Request $request, $leverancierId, $productId)
    {
        $request->validate([
            'houdbaarheidsdatum' => 'required|date'
        ]);
        
        try {
            // Update product using model
            $result = Leverancier::updateProductHoudbaarheidsdatum($productId, $request->houdbaarheidsdatum);
            
            if ($result['success']) {
                return redirect()
                    ->route('leverancier.product.edit', [$leverancierId, $productId])
                    ->with('success', $result['message']);
            } else {
                return redirect()
                    ->route('leverancier.product.edit', [$leverancierId, $productId])
                    ->with('error', $result['message'])
                    ->withInput();
            }
        } catch (Exception $e) {
            Log::error('Error updating product ' . $productId . ': ' . $e->getMessage());
            
            return redirect()
                ->route('leverancier.product.edit', [$leverancierId, $productId])
                ->with('error', 'Er is een fout opgetreden bij het wijzigen van de houdbaarheidsdatum.')
                ->withInput();
        }
    }
}

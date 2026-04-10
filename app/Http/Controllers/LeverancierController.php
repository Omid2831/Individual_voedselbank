<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeverancierController extends Controller
{
    public function index()
    {
        // Call stored procedure to get all leveranciers
        $leveranciers = DB::select('CALL sp_getAllLeverancier()');
        
        return view('leverancier.index', compact('leveranciers'));
    }
    
    public function products($id)
    {
        // Get leverancier details
        $leveranciers = DB::select('CALL sp_getAllLeverancier()');
        $leverancier = collect($leveranciers)->firstWhere('Id', $id);
        
        if (!$leverancier) {
            return redirect()->route('leverancier.index')->with('error', 'Leverancier niet gevonden');
        }
        
        // Get products for this leverancier
        $products = DB::select('CALL sp_getProductsByLeverancier(?)', [$id]);
        
        return view('leverancier.products', compact('leverancier', 'products'));
    }
    
    public function editProduct($leverancierId, $productId)
    {
        // Get leverancier details
        $leveranciers = DB::select('CALL sp_getAllLeverancier()');
        $leverancier = collect($leveranciers)->firstWhere('Id', $leverancierId);
        
        if (!$leverancier) {
            return redirect()->route('leverancier.index')->with('error', 'Leverancier niet gevonden');
        }
        
        // Get product details
        $products = DB::select('CALL sp_getProductsByLeverancier(?)', [$leverancierId]);
        $product = collect($products)->firstWhere('Id', $productId);
        
        if (!$product) {
            return redirect()->route('leverancier.products', $leverancierId)->with('error', 'Product niet gevonden');
        }
        
        return view('leverancier.edit-product', compact('leverancier', 'product'));
    }
    
    public function updateProduct(Request $request, $leverancierId, $productId)
    {
        $request->validate([
            'houdbaarheidsdatum' => 'required|date'
        ]);
        
        // Call stored procedure with OUT parameters
        $result = DB::select('CALL sp_updateProductHoudbaarheidsdatum(?, ?, @result, @message)', [
            $productId,
            $request->houdbaarheidsdatum
        ]);
        
        // Get OUT parameters
        $output = DB::select('SELECT @result as result, @message as message')[0];
        
        if ($output->result == 1) {
            return redirect()
                ->route('leverancier.product.edit', [$leverancierId, $productId])
                ->with('success', $output->message);
        } else {
            return redirect()
                ->route('leverancier.product.edit', [$leverancierId, $productId])
                ->with('error', $output->message)
                ->withInput();
        }
    }
}

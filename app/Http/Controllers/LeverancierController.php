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
}

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
}

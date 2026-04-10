<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allergie;

class AllergieController extends Controller
{
    /**
     * Toont het overzicht van gezinnen met allergieën.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function overzicht(Request $request)
    {
        $allergieNaam = $request->input('allergie_naam');
        
        // Haal gezinnen op via de stored procedure in het Allergie model
        $gezinnen = Allergie::getGezinnenMetAllergieen($allergieNaam);

        // Haal alle allergieën op voor de dropdown
        $allergyList = Allergie::getAllAllergies();

        return view('allergeen.overzicht_allergieen', compact('gezinnen', 'allergieNaam', 'allergyList'));
    }
}

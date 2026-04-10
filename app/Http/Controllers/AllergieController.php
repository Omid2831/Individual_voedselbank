<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Allergie;
use Illuminate\Support\Facades\DB;

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

    $resultaten = collect(Allergie::getGezinnenMetAllergieen($allergieNaam));

    $perPage = 10;
    $page = LengthAwarePaginator::resolveCurrentPage();

    $gezinnen = new LengthAwarePaginator(
        $resultaten->forPage($page, $perPage),
        $resultaten->count(),
        $perPage,
        $page,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );

    $allergyList = Allergie::getAllAllergies();

    return view('allergeen.overzicht_allergieen', compact(
        'gezinnen',
        'allergyList',
        'allergieNaam'
    ));
}

    /**
     * Toont het detailoverzicht van allergieën voor een specifiek gezin.
     * 
     * @param int $gezin_id
     * @return \Illuminate\View\View
     */
    public function detail($gezin_id)
    {
        $details = Allergie::getGezinAllergieDetails($gezin_id);

        if (empty($details)) {
            abort(404, 'Gezin niet gevonden of geen details beschikbaar.');
        }

        // Haal gezinsinfo uit de eerste rij
        $gezinInfo = $details[0];

        return view('allergeen.allergeen_detail', compact('details', 'gezinInfo'));
    }

    /**
     * Toont het formulier om een allergie te wijzigen.
     */
    public function edit($persoon_id)
    {
        $persoonAllergie = Allergie::getPersoonAllergie($persoon_id);

        if (!$persoonAllergie) {
            abort(404, 'Gezinslid niet gevonden.');
        }

        $allAllergies = Allergie::getAllAllergies();
        
        // Bepaal of we een waarschuwing moeten tonen (Anaphylactic risk)
        $showWarning = in_array(strtolower($persoonAllergie->AnafylactischRisico), ['hoog', 'redelijkhoog']);

        return view('allergeen.allergeen_wijzigen', compact('persoonAllergie', 'allAllergies', 'showWarning'));
    }

    /**
     * Slaat de gewijzigde allergie op.
     */
    public function update(Request $request, $persoon_id)
    {
        $request->validate([
            'allergie_id' => 'required|exists:Allergie,Id'
        ]);

        // Haal GezinId ALTIJD op via de Persoon tabel (veel betrouwbaarder dan via mapping tabel)
        $persoon = DB::table('Persoon')->where('Id', $persoon_id)->first();
        $gezinId = $persoon ? $persoon->GezinId : null;

        // Gebruik de nieuwe sync methode die INSERT of UPDATE afhandelt
        Allergie::syncPersoonAllergie($persoon_id, $request->input('allergie_id'));

        return view('allergeen.allergeen_gewijzigd', compact('gezinId'));
    }
}

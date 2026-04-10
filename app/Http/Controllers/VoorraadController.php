<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class VoorraadController extends Controller
{
    public function overzicht(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        $categorie = $request->get('categorie', '');

        // Get categories for dropdown
        $categories = DB::table('Categorie')->select('Id', 'Naam')->get();

        // Get all voorraad from stored procedure
        $allVoorraad = DB::select('CALL sp_getAllVoorraad()');

        // Filter by category if selected
        if ($categorie) {
            $allVoorraad = array_filter($allVoorraad, function ($item) use ($categorie) {
                return $item->Categorie === $categorie;
            });
            $allVoorraad = array_values($allVoorraad);
        }

        $voorraad = new LengthAwarePaginator(
            collect($allVoorraad)->forPage($page, $perPage)->values(),
            count($allVoorraad),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('voorraad.overzicht', compact('voorraad', 'categories', 'categorie'));
    }
}

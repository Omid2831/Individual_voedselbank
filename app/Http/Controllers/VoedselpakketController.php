<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use DB;
use Illuminate\Http\Request;

class VoedselpakketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $eetwensen = DB::table('Eetwens')->get();
            $eetwensId = $request->input('eetwens_id');

            // We roepen de procedure ALTIJD aan.
            // Als $eetwensId null is, zorgt de ELSE in de database nu voor de volledige lijst.
            $gezinnen = Voedselpakket::getOverzicht($eetwensId);

            return view('voedselpakket.index', compact('gezinnen', 'eetwensen'));

        } catch (\Exception $e) {
            return back()->withErrors('Fout: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Haal alle data op via de nieuwe procedure
        $data = DB::select('CALL spGetPakketDetailsPerGezin(?)', [$id]);

        // Omdat de gezinsinfo in elke rij hetzelfde is, pakken we de eerste rij voor de bovenste tabel
        // Als $data leeg is (gezin bestaat niet), sturen we een 404
        if (empty($data)) {
            abort(404);
        }

        $gezinInfo = $data[0];

        // De hele lijst ($data) gebruiken we voor de pakketten-tabel
        // We checken wel of er echt een pakket is (PakketId mag niet null zijn door de LEFT JOIN)
        $pakketten = collect($data)->whereNotNull('PakketId');

        return view('voedselpakket.show', [
            'gezin' => $gezinInfo,
            'pakketten' => $pakketten,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Haal het pakket op via het Model
        $pakket = Voedselpakket::getPakketVoorEdit($id);

        // Als het pakket niet bestaat, geef een 404
        if (! $pakket) {
            abort(404);
        }

        // Check of het GEZIN geblokkeerd is
        // Omdat getPakketVoorEdit een object teruggeeft, werkt $pakket->GezinId hier:
        $isGezinGeblokkeerd = DB::table('Voedselpakket')
            ->where('GezinId', $pakket->GezinId)
            ->where('Status', 'NietMeerIngeschreven')
            ->exists();

        return view('voedselpakket.edit', compact('pakket', 'isGezinGeblokkeerd'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Haal gezinId op voor de redirect later
            $gezinId = DB::table('Voedselpakket')->where('Id', $id)->value('GezinId');

            // HIER maak je de connectie met het model
            Voedselpakket::updatePakketStatus($id, $request->status);

            return redirect()->route('voedselpakket.show', $gezinId)->with('success', 'Het Gezin is succesvol bijgewerkt.');
        } catch (\Exception $e) {
            // Als de model/procedure een error geeft, kom je hier
            return redirect()->back()->with('error', 'Update mislukt: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voedselpakket $voedselpakket)
    {
        //
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Allergie extends Model
{
    /**
     * Haal een overzicht op van alle gezinnen met een allergie 
     * en eventueel gefilterd op een bepaalde allergie.
     * 
     * @param string|null $allergieNaam
     * @return array
     */
public static function getGezinnenMetAllergieen($allergieNaam = null)
{
    return DB::select('CALL Sp_GetAllAllergieen(?)', [$allergieNaam]);
}

    /**
     * Haal alle actieve allergieën op voor de dropdown.
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getAllAllergies()
    {
        return DB::table('Allergie')->where('IsActive', 1)->get();
    }

    /**
     * Haal alle personen van een gezin en hun bijbehorende allergieën op.
     * 
     * @param int $gezinId
     * @return array
     */
    public static function getGezinAllergieDetails($gezinId)
    {
        return DB::select('CALL Sp_GetAllergieenDetailsPerGezin(?)', [$gezinId]);
    }

    /**
     * Haal een persoon-allergie record op voor het bewerken.
     * 
     * @param int $persoonId
     * @return object|null
     */
    public static function getPersoonAllergie($persoonId)
    {
        $result = DB::select('CALL Sp_GetPersoonAllergieForEdit(?)', [$persoonId]);
        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Wijzig de allergie van een specifiek persoon.
     * 
     * @param int $allergiePerPersoonId
     * @param int $newAllergieId
     * @return void
     */
    public static function updatePersoonAllergie($allergiePerPersoonId, $newAllergieId)
    {
        DB::select('CALL Sp_UpdatePersoonAllergie(?, ?)', [$allergiePerPersoonId, $newAllergieId]);
    }
}

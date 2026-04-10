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
}

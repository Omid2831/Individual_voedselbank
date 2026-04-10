<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Voedselpakket extends Model
{
    protected $table = 'Voedselpakket';

    /**
     * Roept de stored procedure aan die de gezinnen filtert op eetwens
     */
    public static function getOverzicht($eetwensId)
    {
        // De procedure heeft zelf al een IF-ELSE, dus we sturen het ID gewoon door
        $resultDB = DB::select('CALL spGetGezinOverzicht(?)', [$eetwensId]);

        return $resultDB;
    }

    public static function getPakkettenByGezin($gezinId)
    {
        return DB::select('CALL spGetPakketDetailsPerGezin(?)', [$gezinId]);
    }

    public static function getPakketVoorEdit($id)
    {
        // Zorg dat de procedure 'G.Status AS GezinStatus' teruggeeft!
        return DB::select('CALL spGetPakketVoorEdit(?)', [$id]);
    }
}

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
        try {
            // Omdat de procedure zelf al een IF-ELSE heeft, sturen we het ID gewoon door. Als het null is, zorgt de procedure voor de volledige lijst.
            $resultDB = DB::select('CALL spGetGezinOverzicht(?)', [$eetwensId]);

            return $resultDB;
        } catch (\Throwable $e) {
            // Log de fout of handel deze af zoals gewenst
            \Log::error('Error in getOverzicht: ' . $e->getMessage());

            return [];
        }
    }

    public static function getPakkettenByGezin($gezinId)
    {
        try {
            $result = DB::select('CALL spGetPakketDetailsPerGezin(?)', [$gezinId]);

            return $result;
        } catch (\Throwable $e) {
            // Log de fout of handel deze af zoals gewenst
            \Log::error('Error in getPakkettenByGezin: ' . $e->getMessage());

            return [];
        }
    }

    public static function getPakketVoorEdit($id)
    {
        try {
            // selectOne zorgt ervoor dat je direct 1 object krijgt in plaats van een array
            $result = DB::selectOne('CALL spGetPakketVoorEdit(?)', [$id]);

            return $result;
        } catch (\Throwable $e) {
            // Belangrijk: gebruik \Log::error in plaats van log()
            \Log::error('Error in getPakketVoorEdit: ' . $e->getMessage());

            return null;
        }
    }

    public static function updatePakketStatus($id, $status)
    {
        // Als je wilt, kun je ook een try-catch blok toevoegen om eventuele fouten af te handelen
        try {
            DB::statement('CALL spUpdatePakket(?, ?)', [$id, $status]);

            return true;
        } catch (\Throwable $e) {
            // Log de fout of handel deze af zoals gewenst
            \Log::error('Error in updatePakketStatus: ' . $e->getMessage());

            return false;
        }
    }
}

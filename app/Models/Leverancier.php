<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class Leverancier extends Model
{
    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    /* Get all active leveranciers using stored procedure */
    public static function getAllLeveranciers()
    {
        try {
            return DB::select('CALL sp_getAllLeverancier()');
        } catch (Exception $e) {
            Log::error('Error in Leverancier model - getAllLeveranciers: ' . $e->getMessage());
            throw $e;
        }
    }

    /* Get leverancier by ID */
    public static function getLeverancierById($id)
    {
        try {
            return DB::table('Leverancier')
                ->where('Id', $id)
                ->where('IsActive', 1)
                ->first();
        } catch (Exception $e) {
            Log::error('Error in Leverancier model - getLeverancierById: ' . $e->getMessage());
            throw $e;
        }
    }

    /* Get products for a specific leverancier using stored procedure */
    public static function getProductsByLeverancier($leverancierId)
    {
        try {
            return DB::select('CALL sp_getProductsByLeverancier(?)', [$leverancierId]);
        } catch (Exception $e) {
            Log::error('Error in Leverancier model - getProductsByLeverancier: ' . $e->getMessage());
            throw $e;
        }
    }

    /* Update product expiry date with validation */
    public static function updateProductHoudbaarheidsdatum($productId, $nieuweDatum)
    {
        try {
            // Call stored procedure with validation
            DB::select('CALL sp_updateProductHoudbaarheidsdatum(?, ?, @result, @message)', [
                $productId,
                $nieuweDatum
            ]);
            
            // Get result from stored procedure
            $output = DB::select('SELECT @result as result, @message as message')[0];
            
            return [
                'success' => $output->result == 1,
                'message' => $output->message
            ];
        } catch (Exception $e) {
            Log::error('Error in Leverancier model - updateProductHoudbaarheidsdatum: ' . $e->getMessage());
            throw $e;
        }
    }
}

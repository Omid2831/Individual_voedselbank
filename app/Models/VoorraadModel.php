<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class VoorraadModel extends Model
{
    // pak de voorraadgegevens uit de database van de storeprocedure
    public function getAllVoorraad()
    {
        try
        {
        // call the stored procedure to get the voorraad data
        $voorraadData = DB::select('CALL GetVoorraadData()');
        return $voorraadData;
        }
        catch (\Exception $e)
        {
            // Log de foutmelding
            Log::error('Fout bij het ophalen van voorraadgegevens: ' . $e->getMessage());

        }
    }
}

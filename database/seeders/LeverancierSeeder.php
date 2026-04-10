<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeverancierSeeder extends Seeder
{
    /* Run database seeds for leverancier tables and stored procedures */
    public function run(): void
    {
        // Read SQL files
        $createTablesSQL = file_get_contents(database_path('sp-leverancier/00-create-tables.sql'));
        $storedProcSQL = file_get_contents(database_path('sp-leverancier/sp_getAllLeverancier.sql'));
        $getProductsSQL = file_get_contents(database_path('sp-leverancier/sp_getProductsByLeverancier.sql'));
        $updateProductSQL = file_get_contents(database_path('sp-leverancier/sp_updateProductHoudbaarheidsdatum.sql'));
        
        // Execute create tables SQL
        DB::unprepared($createTablesSQL);
        echo "✓ Tables created and data inserted\n";
        
        // Execute stored procedures
        DB::unprepared($storedProcSQL);
        echo "✓ Stored procedure sp_getAllLeverancier created\n";
        
        DB::unprepared($getProductsSQL);
        echo "✓ Stored procedure sp_getProductsByLeverancier created\n";
        
        DB::unprepared($updateProductSQL);
        echo "✓ Stored procedure sp_updateProductHoudbaarheidsdatum created\n";
    }
}

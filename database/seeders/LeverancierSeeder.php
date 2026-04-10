<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeverancierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read and execute the SQL files
        $createTablesSQL = file_get_contents(database_path('sp-leverancier/00-create-tables.sql'));
        $storedProcSQL = file_get_contents(database_path('sp-leverancier/sp_getAllLeverancier.sql'));
        $getProductsSQL = file_get_contents(database_path('sp-leverancier/sp_getProductsByLeverancier.sql'));
        $updateProductSQL = file_get_contents(database_path('sp-leverancier/sp_updateProductHoudbaarheidsdatum.sql'));
        
        // Execute create tables SQL
        DB::unprepared($createTablesSQL);
        echo "✓ Tables created and data inserted\n";
        
        // Execute stored procedure SQL
        DB::unprepared($storedProcSQL);
        echo "✓ Stored procedure sp_getAllLeverancier created\n";
        
        // Execute get products stored procedure
        DB::unprepared($getProductsSQL);
        echo "✓ Stored procedure sp_getProductsByLeverancier created\n";
        
        // Execute update product stored procedure
        DB::unprepared($updateProductSQL);
        echo "✓ Stored procedure sp_updateProductHoudbaarheidsdatum created\n";
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Hans',
                'email' => 'hans@maaskantje.nl',
                'password' => Hash::make('12345678'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jan',
                'email' => 'jan@maaskantje.nl',
                'password' => Hash::make('12345678'),
                'role' => 'medewerker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Herman',
                'email' => 'herman@maaskantje.nl',
                'password' => Hash::make('12345678'),
                'role' => 'vrijwilliger',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereIn('email', ['hans@maaskantje.nl', 'jan@maaskantje.nl', 'herman@maaskantje.nl'])->delete();
    }
};

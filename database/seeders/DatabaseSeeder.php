<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,      // ← pertama, karena tabel lain butuh user_id
            CarTypeSeeder::class,    // ← kedua, kalau cars butuh car_type_id
            CarSeeder::class,        // ← ketiga
            ReviewSeeder::class,     // ← terakhir, karena butuh car & user
        ]);
    }
}

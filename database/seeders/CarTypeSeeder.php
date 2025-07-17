<?php

namespace Database\Seeders;

use App\Models\CarType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $filePath = database_path('seeders/data/used_car_tahun_brand_model_unique_sorted.csv');

        if (!File::exists($filePath)) {
            $this->command->error("File CSV tidak ditemukan di: {$filePath}");
            return;
        }

        $csvData = array_map('str_getcsv', file($filePath));
        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            CarType::create([
                'tahun' => $data['tahun'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Data cars_type berhasil di-seed dari CSV.');
    }
}

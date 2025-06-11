<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarPhoto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $car = Car::create([
            'user_id' => 1,
            'brand' => 'Toyota',
            'model' => 'AVANZA VELOZ',
            'year' => '2021',
            'price' => '100000000',
            'transmission' => 'automatic',
            'description' => 'lorem lorem lore',
            'service_history' => '2024-05-20',
            'fuel_type' => 'bensin',
            'mileage' => '100000',
            'color' => 'silver',
            'sale_type' => 'showroom',
            'status' => 'pending_check',
        ]);

        foreach (range(1, 5) as $i) {
            CarPhoto::create([
                'car_id' => $car->id,
                'photo_url' => "$i.jpg",
                'number' => $i,
            ]);
        }
    }

}

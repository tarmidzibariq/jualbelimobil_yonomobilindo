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
            'description' => 'Toyota Alphard menjadi salah satu mobil MPV mewah dengan angka penjualan yang cukup tinggi.
                Ukuran yang besar dengan interior yang mewah menjadikan mobil ini sebagai mobil standar bagi
                kalangan menengah atas di Indonesia. Segera jadwalkan untuk informasi lebih lanjut.',
            'service_history' => '2024-05-20',
            'fuel_type' => 'bensin',
            'mileage' => '100000',
            'color' => 'silver',
            'tax' => '2025-05-20',
            'engine' => '2500',
            'bpkb'=> true,
            'spare_key'=> true,
            'manual_book'=> true,
            'service_book'=> true,
            'sale_type' => 'showroom',
            'seat' => '4',
            'status' => 'available',
        ]);

        foreach (range(1, 5) as $i) {
            CarPhoto::create([
                'car_id' => $car->id,
                'photo_url' => "$i.jpg",
                'number' => $i,
            ]);
        }

        $car = Car::create([
            'user_id' => 1,
            'brand' => 'Dhaihatsu',
            'model' => 'Ayla',
            'year' => '2021',
            'price' => '90000000',
            'transmission' => 'automatic',
            'description' => 'Toyota Alphard menjadi salah satu mobil MPV mewah dengan angka penjualan yang cukup tinggi.
                Ukuran yang besar dengan interior yang mewah menjadikan mobil ini sebagai mobil standar bagi
                kalangan menengah atas di Indonesia. Segera jadwalkan untuk informasi lebih lanjut.',
            'service_history' => '2024-05-20',
            'fuel_type' => 'bensin',
            'mileage' => '100000',
            'color' => 'silver',
            'tax' => '2025-05-20',
            'engine' => '2500',
            'bpkb'=> true,
            'spare_key'=> true,
            'manual_book'=> true,
            'service_book'=> true,
            'sale_type' => 'showroom',
            'seat' => '4',
            'status' => 'available',
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

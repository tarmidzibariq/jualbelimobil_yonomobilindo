<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Review::create([
                'user_id' => 2,
                'sales_record_id' => null,
                'car_id' => null,
                'rating' => 5,
                'photo_review' => "$i.jpeg",
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\Bicycle;
use Illuminate\Database\Seeder;

class BicycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample bicycles
        $bicycles = [
            [
                'name' => 'Mountain Bike 1',
                'color' => 'Red',
                'status' => 'available',
            ],
            [
                'name' => 'City Bike 1',
                'color' => 'Blue',
                'status' => 'available',
            ],
            [
                'name' => 'Road Bike 1',
                'color' => 'Black',
                'status' => 'available',
            ],
        ];

        foreach ($bicycles as $bicycle) {
            Bicycle::create($bicycle);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = ['Standard', 'Deluxe', 'Suite', 'Presidential'];

        for ($i = 1; $i <= 10; $i++) {
            Room::create([
                'number' => 'R' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'type' => $roomTypes[array_rand($roomTypes)],
                'is_available' => true,
            ]);
        }
    }
}

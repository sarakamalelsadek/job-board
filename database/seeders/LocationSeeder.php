<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            ['city' => 'Cairo', 'state' => 'Cairo', 'country' => 'Egypt'],
            ['city' => 'Dubai', 'state' => 'Dubai', 'country' => 'UAE'],
            ['city' => 'New York', 'state' => 'NY', 'country' => 'USA'],
            ['city' => 'London', 'state' => 'London', 'country' => 'UK'],
        ]);
    }
}

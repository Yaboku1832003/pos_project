<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            ['name' => 'Microcontrollers & Development Boards', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sensors & Measurement Modules', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Robotics & STEM Kits', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Displays & Visual Modules', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motors & Actuators', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Communication & IoT Modules', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Audio & Amplifier Modules', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tools & Accessories', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Power Supply & Conversion Modules', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Connectors & Passive Components', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Integrated Circuits (ICs)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agriculture & Programming Modules', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}


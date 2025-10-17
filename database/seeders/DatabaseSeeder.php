<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if superadmin exists first
        if (!User::where('email', 'superadmin@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin Account',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('admin12345'),
                'role' => 'superadmin',
                'profile' =>'superAdmin.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Call other seeders
        $this->call([
            ProductSeeder::class,
        ]);
    }
}

<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@sisantri.com',
            'password' => Hash::make('Password@123'),
            'role'     => 'admin',
        ]);

        // Create mentor with factory
        User::factory(3)->mentor()->create();

        // Create santri with factory
        User::factory(50)->santri()->create();
    }
}

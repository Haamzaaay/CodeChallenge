<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();

        User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ]);
    }
}

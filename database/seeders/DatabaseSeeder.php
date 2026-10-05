<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'sirspondokkopi@gmail.com'],
            [
                'name' => 'Administrator',
                'no_pegawai' => '1212',
                'password' => 'rsijpk1212',
            ],
        );

        $this->call(DoctorSeeder::class);
    }
}

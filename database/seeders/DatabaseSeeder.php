<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\Maintenance;
use App\Models\User;
use Database\Factories\CarFactory;
use Database\Factories\MaintenanceFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('12345678')
        ])->count(1)->has(Car::factory()->count(3)->has(Maintenance::factory()->count(6)))->create();


        User::factory()->count(1)
            ->has(Car::factory()
            ->has(Maintenance::factory()->count(5)))
            ->create();

        User::factory()->count(1)
            ->has(Car::factory()
            ->has(Maintenance::factory()->count(5)))
            ->create();

        User::factory()->count(1)
            ->has(Car::factory()
            ->has(Maintenance::factory()->count(5)))
            ->create();

    }
}

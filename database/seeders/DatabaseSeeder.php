<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Agent;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);
        User::factory(10)->create()->each(fn($user) => $user->assignRole(RoleEnum::USER->value));
        Agent::factory(10)->create()->each(fn($user) => $user->assignRole(RoleEnum::AGENT->value));

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}

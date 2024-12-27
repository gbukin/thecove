<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!app()->isProduction()) {
            User::factory()->create([
                'name' => 'dev',
                'email' => 'dev@thecove.com',
                'password' => bcrypt('dev'),
            ]);
        }
    }
}

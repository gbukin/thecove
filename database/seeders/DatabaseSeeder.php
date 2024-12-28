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
        if (app()->isLocal()) {
            User::factory()->create([
                'name' => 'dev',
                'email' => 'dev@thecove.com',
                'password' => bcrypt('dev'),
            ]);
        }

        if (app()->isProduction()) {
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@thecove.com',
                'password' => bcrypt('mY-p@$$w0Rd-$tR0nG'),
            ]);
        }
    }
}

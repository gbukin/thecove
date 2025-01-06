<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Language;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()->create([
                'name' => 'dev',
                'email' => 'dev@dev',
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

        try {
            Language::create(['name' => 'en']);
            Language::create(['name' => 'ru']);
        } catch (\Throwable) {
            // Nothing
        }
    }
}

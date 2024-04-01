<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
        ]);

        if (app()->isLocal()) {
            $this->runLocal();
        }
    }

    protected function runLocal(): void
    {
        $this->call([
            ProductSeeder::class,
            UserSeeder::class,
        ]);
    }
}

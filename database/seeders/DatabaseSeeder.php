<?php

namespace Database\Seeders;

use App\Support\SiteAdmin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SiteAdmin::ensure();
    }
}

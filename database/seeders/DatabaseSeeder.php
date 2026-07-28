<?php

namespace Database\Seeders;

use App\Support\SiteAdmin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        SiteAdmin::ensure();

        $this->call([
            BlogSeeder::class,
        ]);
    }
}

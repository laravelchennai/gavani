<?php

namespace Database\Seeders;

use App\Models\Monitoring\Site;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeedr::class,
            RoleSeedr::class,
            UserSeedr::class,
        ]);

        // Site::factory()->count(20)->create();
    }
}

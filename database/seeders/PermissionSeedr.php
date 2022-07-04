<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeedr extends Seeder
{
    public static $permissionsList = [

        'USER.VIEW',
        'USER.CREATE',
        'USER.UPDATE',
        'USER.DELETE',

        'ROLE.VIEW',
        'ROLE.CREATE',
        'ROLE.UPDATE',
        'ROLE.DELETE',

        'PERMISSION.VIEW',
        'PERMISSION.CREATE',
        'PERMISSION.UPDATE',
        'PERMISSION.DELETE',

        'SITE.VIEW',
        'SITE.CREATE',
        'SITE.UPDATE',
        'SITE.DELETE',
        'SITE.EXPORT',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = static::$permissionsList;

        foreach ($permissions as $eachPermissionArray) {
            Permission::query()->firstOrCreate(['name' => $eachPermissionArray]);
        }
    }
}

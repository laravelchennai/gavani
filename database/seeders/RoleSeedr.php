<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RoleSeedr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = Permission::query()
                        ->get();

        $roles = [
            [
                'name' => 'Root',
                'permission' => $allPermissions,
            ],
            [
                'name' => 'Admin',
                'permission' => $allPermissions->filter(function ($eachPermission) {
                    return ! Str::endsWith($eachPermission->name, ['.DELETE']);
                }),
            ],
            [
                'name' => 'User',
                'permission' => $allPermissions->filter(function ($eachPermission) {
                    return Str::endsWith($eachPermission->name, ['.VIEW']);
                })->filter(function ($eachPermission) {
                    return ! Str::startsWith($eachPermission->name, ['CUSTOMER.']);
                })
                ->filter(function ($eachPermission) {
                    return ! Str::endsWith($eachPermission->name, ['EXPORT.']);
                }),
            ],
        ];

        foreach ($roles as $eachRoleArray) {
            $role = Role::query()->firstOrCreate(Arr::only($eachRoleArray, ['name']));
            $role->revokePermissionTo($allPermissions);
            $role->syncPermissions(Arr::only($eachRoleArray, ['permission']));
        }
    }
}

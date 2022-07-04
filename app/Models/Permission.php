<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as SpatiePermissionModel;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|array<SpatiePermissionModel> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends SpatiePermissionModel
{
    /**
     * Get the Group of the Permission
     *
     * @return string
     **/
    public function getPermissionGroupName()
    {
        return match(true) {
            Str::startsWith($this->name, 'USERMANAGEMENT.USER.') => 'User',
            Str::startsWith($this->name, 'USERMANAGEMENT.ROLE.') => 'Role',
            Str::startsWith($this->name, 'METADATA.SERVER.OPERATINGSYSTEM.') => 'OS',
            Str::startsWith($this->name, 'METADATA.SERVER.OPERATINGSYSTEMVERSION.') => 'OS Version',
            Str::startsWith($this->name, 'METADATA.SERVER.CPUCAPACITY.') => 'CPU',
            Str::startsWith($this->name, 'METADATA.SERVER.RAMCAPACITY.') => 'RAM',
            Str::startsWith($this->name, 'METADATA.SERVER.VIRTUALMACHINESIZE.') => 'VM Size',
            Str::startsWith($this->name, 'METADATA.DC.DATACENTER.') => 'DC',
            Str::startsWith($this->name, 'METADATA.DC.DATACENTERREGION.') => 'DC Region',
            Str::startsWith($this->name, 'METADATA.DC.DATACENTERCLUSTER.') => 'DC Cluster',
            Str::startsWith($this->name, 'CUSTOMER.CLIENT.') => 'Client',
            Str::startsWith($this->name, 'CUSTOMER.CLIENT.') => 'Client Company',
            Str::startsWith($this->name, 'CUSTOMER.CLIENT.') => 'Client Company',
            default => 'default'
        };
    }
}
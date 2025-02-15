<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'superAdmin',
                'display_name' => 'Super Admin',
                'is_default' => true,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'is_default' => true,
            ],
            [
                'name' => 'member',
                'display_name' => 'Member',
                'is_default' => true,
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        /** @var Role $adminRole */
        $superAdminRole = Role::whereName('superAdmin')->first();
        $adminRole = Role::whereName('admin')->first();
        $user = User::whereEmail('admin@infybetting.com')->first();
        /** @var User $user */
        $allPermission = Permission::pluck('name', 'id');

        $superAdminRole->givePermissionTo($allPermission);
        $adminRole->givePermissionTo($allPermission);
        if ($user) {
            $user->assignRole($adminRole);
        }
            
    }
}

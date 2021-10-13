<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = [13, 14, 15, 16, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32];
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
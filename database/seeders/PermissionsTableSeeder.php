<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'title' => 'user_management_access',
            ],
            [
                'title' => 'permission_create',
            ],
            [
                'title' => 'permission_edit',
            ],
            [
                'title' => 'permission_show',
            ],
            [
                'title' => 'permission_delete',
            ],
            [
                'title' => 'permission_access',
            ],
            [
                'title' => 'role_create',
            ],
            [
                'title' => 'role_edit',
            ],
            [
                'title' => 'role_show',
            ],
            [
                'title' => 'role_delete',
            ],
            [
                'title' => 'role_access',
            ],
            [
                'title' => 'user_create',
            ],
            [
                'title' => 'user_edit',
            ],
            [
                'title' => 'user_show',
            ],
            [
                'title' => 'user_delete',
            ],
            [
                'title' => 'user_access',
            ],
            [
                'title' => 'category_create',
            ],
            [
                'title' => 'category_edit',
            ],
            [
                'title' => 'category_show',
            ],
            [
                'title' => 'category_delete',
            ],
            [
                'title' => 'category_access',
            ],
            [
                'title' => 'issue_create',
            ],
            [
                'title' => 'issue_edit',
            ],
            [
                'title' => 'issue_show',
            ],
            [
                'title' => 'issue_delete',
            ],
            [
                'title' => 'issue_access',
            ],
            [
                'title' => 'comment_create',
            ],
            [
                'title' => 'comment_edit',
            ],
            [
                'title' => 'comment_show',
            ],
            [
                'title' => 'comment_delete',
            ],
            [
                'title' => 'comment_access',
            ],
            [
                'title' => 'dashboard_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'title'      => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'customer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Role::insert($roles);
    }
}
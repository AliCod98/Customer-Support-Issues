<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'           => 'Admin 1',
                'email'          => 'admin1@admin.com',
                'password'       => bcrypt('admin'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name'           => 'Admin 2',
                'email'          => 'admin2@admin.com',
                'password'       => bcrypt('admin2'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name'           => 'Customer 1',
                'email'          => 'customer1@customer.com',
                'password'       => bcrypt('customer1'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name'           => 'Customer 2',
                'email'          => 'customer2@customer.com',
                'password'       => bcrypt('customer2'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name'           => 'Customer 3',
                'email'          => 'customer3@customer.com',
                'password'       => bcrypt('customer3'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        User::insert($users);
    }
}
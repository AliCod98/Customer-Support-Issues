<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);
        User::findOrFail(2)->roles()->sync(1);
        foreach (range(3, 5) as $id) {
            User::findOrFail($id)->roles()->sync(2);
        }
    }
}
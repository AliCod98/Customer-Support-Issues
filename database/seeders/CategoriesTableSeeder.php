<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Uncategorized", "Billing/Payments", "Technical question"
        ];

        foreach ($categories as $category) {
            Category::create([
                'title'  => $category,
            ]);
        }
    }
}
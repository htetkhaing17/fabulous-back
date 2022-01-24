<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Category::upsert([
            [
                'id' => 1, 'name' => 'Electronics Device', 'slug' => Str::slug('Electronics Device'),
                
                'description' => '', 'parent_id' => null, 'menu' => 0
            ],
                [
                    'id' => 101, 'name' => 'Phones', 'slug' => Str::slug('Phones'),
                    'description' => '', 'parent_id' => 1, 'menu' => 1
                ],
                [
                    'id' => 102, 'name' => 'Laptops', 'slug' => Str::slug('Laptops'),
                    'description' => '', 'parent_id' => 1, 'menu' => 1
                ], 
                    [
                        'id' => 10201, 'name' => 'Laptops & Notebooks', 'slug' => Str::slug('Laptops & Notebooks'),
                        'description' => '', 'parent_id' => 102, 'menu' => 1
                    ], 
                    [
                        'id' => 10202, 'name' => 'Gaming Laptops', 'slug' => Str::slug('Gaming Laptops'),
                        'description' => '', 'parent_id' => 102, 'menu' => 1
                    ], 
                    [
                        'id' => 10203, 'name' => 'Macbooks', 'slug' => Str::slug('Macbooks'),
                        'description' => '', 'parent_id' => 102, 'menu' => 1
                    ],            

        ], ['id']);


    }
}

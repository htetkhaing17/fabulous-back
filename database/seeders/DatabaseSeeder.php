<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\CategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $me = \App\Models\User::create([
            'fullname' => 'Htet Khaing',
            'display_name' => 'Htet Khaing',
            'email' => 'htetkhaing17@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(10)->create();
        
        \App\Models\Product::factory()
        ->count(5000)
        ->create();

        $this->call([
            CategoriesSeeder::class
        ]);


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Product::create(
            [
                'name' => 'Product 1',
                'price' => '100',
                'description' => 'Product 1 description',
                'created_at' => now(),
                'updated_at' => now()
            ]

        );
        Product::create(
            [
                'name' => 'Product 2',
                'price' => '200',
                'description' => 'Product 2 description',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        Product::create(
            [
                'name' => 'Product 3',
                'price' => '300',
                'description' => 'Product 3 description',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        Product::create(
            [
                'name' => 'Product 4',
                'price' => '400',
                'description' => 'Product 4 description',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        Product::create(
            [
                'name' => 'Product 5',
                'price' => '500',
                'description' => 'Product 5 description',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        User::create([
            'name'        => 'Admin',
            'email'       => 'admin@gmail.com',
            'password'    => bcrypt('password'),

        ]);

        User::create([
            'name'        => 'user',
            'email'       => 'user@gmail.com',
            'password'    => bcrypt('password'),

        ]);
    }
}

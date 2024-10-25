<?php

namespace Database\Seeders;

<<<<<<< HEAD

=======
>>>>>>> CRUD_Blog
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
<<<<<<< HEAD
    {     
        $this->call(CategoriesSeeder::class);
        $this->call(ColorSeeder::class);
       
        $this->call(ProductSeeder::class);
        $this->call(UserSeeder::class);
=======
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
>>>>>>> CRUD_Blog
    }
}

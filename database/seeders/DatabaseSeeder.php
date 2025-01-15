<?php

namespace Database\Seeders;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use HasFactory;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call(PostSeeder::class);

        //User::factory()->create([
        //    'name' => 'Test User',
         //   'email' => 'test@example.com',
        //]);
    }
}

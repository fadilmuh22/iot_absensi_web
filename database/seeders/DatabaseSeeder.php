<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::create([
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => bcrypt("admin"),
            'remember_token' => Str::random(10),
            'verified' => 1,
            'role' => 'admin',
        ]);
        \App\Models\User::factory(5)->create();
        \App\Models\Event::factory(5)->create();
    }
}

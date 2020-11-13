<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $admin = \App\Models\User::create([
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => bcrypt("admin"),
            'remember_token' => \Str::random(10),
            'verified' => 1,
            'role' => 'admin',
        ]);
        \App\Models\User::factory(5)->create();
        \App\Models\Event::factory(5)->create();
        for ($i = 1; $i < 5; $i++) {
            \App\Models\Absen::create([
                'event_id' => 1,
                'user_id' => $i,
                'hadir' =>  $faker->numberBetween(0, 1),
                'waktu_hadir' => now(),
            ]);
        }
    }
}

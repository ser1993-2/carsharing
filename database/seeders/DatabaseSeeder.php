<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Rate;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(10)->create();
        CarBrand::factory(10)->create();
        Rate::factory(5)->create();
        Car::factory(10)->create();

        Role::insert([
            ['role' => 'Пользователь'],
            ['role' => 'Администратор'],
        ]);

        User::get()->each(function ($user) {
           UserRole::create([
               'user_id' => $user->id,
               'role_id' => 1 //Пользователь
           ]);
        });

        UserRole::create([
            'user_id' => 1,
            'role_id' => 2 //Администратор
        ]);

    }
}

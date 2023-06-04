<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        if (!User::where('email', 'user@jd.com')->first()) {
            $default_user = User::factory()->makeOne()->toArray();
            $default_user['name'] = 'Default User';
            $default_user['email'] = 'user@jd.com';
            $default_user['password'] = 'userdefault@123';
            User::create($default_user);
        }
        $this->call([
            UserSeeder::class,
        ]);
    }
}

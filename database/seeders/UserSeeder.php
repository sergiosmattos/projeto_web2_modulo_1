<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => "admin",
            'email' => "admin@exemplo.com",
            'permission' => "admin",
            'password' => bcrypt('123456'),
        ]);

        User::factory()->count(4)->create();

    }
}

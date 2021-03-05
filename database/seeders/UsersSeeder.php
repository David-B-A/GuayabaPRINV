<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'David Bello', 'email' => 'sneyder7713@gmail.com', 'password' => Hash::make('1234')]);
        $user->assignRole('Admin');
        //
    }
}

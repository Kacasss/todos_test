<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'テスト花子',
            'email' => 'test1@hanako.com',
            'password' => '$2y$10$cMIxu7U1nrxTqmdXuPJmPuEkvowDgC4q2kd39PqzXyMQku5ZVY2Za', //testhanako1
        ]);

        User::create([
            'name' => 'テスト太郎',
            'email' => 'test2@taro.com',
            'password' => '$2y$10$SODdKUMtmX.HjNMbP8B/KOKucEi4wuiVPXfaEulHYAWSWGWAag5Su', //testtaro2
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama'=>'Danish Hasna',
                'email'=>'danish@gmail.com',
                'password'=>bcrypt('123456'),
                'bagian'=>'Plastik'
            ],
            [
                'nama'=>'Aisya Rahma',
                'email'=>'aisya@gmail.com',
                'password'=>bcrypt('123456'),
                'bagian'=>'Logam'
            ],
            [
                'nama'=>'Laras Ayu',
                'email'=>'laras@gmail.com',
                'password'=>bcrypt('123456'),
                'bagian'=>'Perakitan'
            ]
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}

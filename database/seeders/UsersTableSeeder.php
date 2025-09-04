<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'Kazuki',             // ユーザー名
                'email' => 'kazuki@example.com',        // メールアドレス
                'password' => Hash::make('password123'), // パスワードは暗号化
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'TestUser',
                'email' => 'test@example.com',
                'password' => Hash::make('test'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$Icl8tdiIAar5qjG0TKHX4uQ0l3MwTdWghxR9s32Iv5pXEAFeF8awq',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}

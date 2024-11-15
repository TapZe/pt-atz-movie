<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Main Admin',
                'email' => 'krazil.server@gmail.com',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
                'role_id' => '1',
            ],
        ];

        foreach ($datas as $data) {
            $createdUser = User::create($data);
            $createdUser->email_verified_at = now();
            $createdUser->save();
        }
    }
}

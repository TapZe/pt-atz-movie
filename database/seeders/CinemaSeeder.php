<?php

namespace Database\Seeders;

use App\Models\Cinema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'The Big One',
                'city' => 'Central Jakarta',
                'address' => 'Jl. M.H. Thamrin',
                'open_time' => '09:00',
                'close_time' => '22:00'
            ],
            [
                'name' => 'The Medium One',
                'city' => 'Central Jakarta',
                'address' => 'Jl. Ir.H. Juanda',
                'open_time' => '09:00',
                'close_time' => '22:00'
            ],
            [
                'name' => 'The Grand One',
                'city' => 'Bandung',
                'address' => 'Jl. BKR',
                'open_time' => '09:00',
                'close_time' => '22:00'
            ],
        ];

        foreach ($datas as $data) {
            Cinema::create($data);
        }
    }
}

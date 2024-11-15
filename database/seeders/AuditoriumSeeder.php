<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Galaxy 1',
                'cinema_id' => 1,
            ],
            [
                'name' => 'Galaxy 2',
                'cinema_id' => 1,
            ],
            [
                'name' => 'Andromeda 1',
                'cinema_id' => 1,
            ],
            [
                'name' => 'Galaxy 3',
                'cinema_id' => 1,
            ],
            [
                'name' => 'Milky Way 1',
                'cinema_id' => 2,
            ],
            [
                'name' => 'Milky Way 2',
                'cinema_id' => 2,
            ],
            [
                'name' => 'Galaxy 1',
                'cinema_id' => 3,
            ],
            [
                'name' => 'Galaxy 2',
                'cinema_id' => 3,
            ],
            [
                'name' => 'Andromeda 1',
                'cinema_id' => 3,
            ],
            [
                'name' => 'Galaxy 3',
                'cinema_id' => 3,
            ],
            [
                'name' => 'Milky Way 1',
                'cinema_id' => 3,
            ],
            [
                'name' => 'Milky Way 2',
                'cinema_id' => 3,
            ],
        ];

        foreach ($datas as $data) {
            Auditorium::create($data);
        }
    }
}

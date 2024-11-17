<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use App\Models\Cinema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cinemas = Cinema::all();
        $datas = [
            [
                'name' => 'Galaxy 1',
                'cinema_id' => $cinemas[0]->id,
            ],
            [
                'name' => 'Galaxy 2',
                'cinema_id' => $cinemas[0]->id,
            ],
            [
                'name' => 'Andromeda 1',
                'cinema_id' => $cinemas[0]->id,
            ],
            [
                'name' => 'Galaxy 3',
                'cinema_id' => $cinemas[0]->id,
            ],
            [
                'name' => 'Milky Way 1',
                'cinema_id' => $cinemas[1]->id,
            ],
            [
                'name' => 'Milky Way 2',
                'cinema_id' => $cinemas[1]->id,
            ],
            [
                'name' => 'Galaxy 1',
                'cinema_id' => $cinemas[2]->id,
            ],
            [
                'name' => 'Galaxy 2',
                'cinema_id' => $cinemas[2]->id,
            ],
            [
                'name' => 'Andromeda 1',
                'cinema_id' => $cinemas[2]->id,
            ],
            [
                'name' => 'Galaxy 3',
                'cinema_id' => $cinemas[2]->id,
            ],
            [
                'name' => 'Milky Way 1',
                'cinema_id' => $cinemas[2]->id,
            ],
            [
                'name' => 'Milky Way 2',
                'cinema_id' => $cinemas[2]->id,
            ],
        ];

        foreach ($datas as $data) {
            Auditorium::create($data);
        }
    }
}

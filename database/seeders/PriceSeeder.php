<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Regular - Weekdays',
                'number' => 40000,
            ],
            [
                'name' => 'Regular - Weekends',
                'number' => 50000,
            ],
        ];

        foreach ($datas as $data) {
            Price::create($data);
        }
    }
}

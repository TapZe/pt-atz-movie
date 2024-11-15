<?php

namespace Database\Seeders;

use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [];
        $maxRows = 14; // Rows A to N (14 rows)
        $maxColumns = 20; // Columns 1 to 20

        for ($i = 0; $i < $maxRows; $i++) {
            $row = chr(ord('A') + $i); // Convert index to corresponding letter (A-N)
            for ($j = 1; $j <= $maxColumns; $j++) {
                $datas[] = ['seat_code' => $row . $j];
            }
        }

        foreach ($datas as $data) {
            Seat::create($data);
        }
    }
}

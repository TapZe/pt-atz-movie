<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Winter Sale',
                'description' => 'Get 20% off on all items!',
                'image' => 'https://freedesignfile.com/upload/2015/12/Winter-sale-background-with-red-ribbon-vector.jpg',
                'code' => 'WINTER20',
                'type' => 'percentage',
                'discount' => '20',
                'start_date' => '2024-11-01',
                'end_date' => '2025-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grand Opening Deal',
                'description' => 'Flat off Rp. 10000 discount for your first purcase!',
                'image' => 'https://doyanayam.com/wp-content/uploads/2023/08/asd.jpg',
                'code' => 'OPENSESAME10',
                'type' => 'fixed',
                'discount' => '10000',
                'start_date' => '2024-11-01',
                'end_date' => '2025-02-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($datas as $data) {
            Promo::create($data);
        }
    }
}

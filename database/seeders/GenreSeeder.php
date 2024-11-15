<?php

namespace Database\Seeders;

use App\Models\Genre;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->request('GET', env('TMDB_API_URI') . 'genre/movie/list?language=en', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TMDB_API_KEY'),
                'accept' => 'application/json',
            ],
        ]);

        $responseJson = json_decode($response->getBody());
        $datas = $responseJson->genres;

        $genresData = array_map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $datas);
        Genre::upsert($genresData, ['id'], ['name']);
    }
}

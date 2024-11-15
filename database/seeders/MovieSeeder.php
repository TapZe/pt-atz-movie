<?php

namespace Database\Seeders;

use App\Models\Movie;
use DB;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Log;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->request('GET', env('TMDB_API_URI') . 'movie/now_playing?language=en-US&page=1&region=ID', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TMDB_API_KEY'),
                'accept' => 'application/json',
            ],
        ]);

        $responseJson = json_decode($response->getBody());
        $datas = $responseJson->results;

        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                $detailResponse = $client->request('GET', env('TMDB_API_URI') . 'movie/' . $data->id . '?language=en-US', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('TMDB_API_KEY'),
                        'accept' => 'application/json',
                    ],
                ]);
                $detailJson = json_decode($detailResponse->getBody());
                $runtime = $detailJson->runtime;

                $movie = Movie::updateOrCreate(
                    ['third_party_id' => $data->id],
                    [
                        'original_title' => $data->original_title,
                        'title' => $data->title,
                        'original_language' => $data->original_language,
                        'overview' => $data->overview,
                        'release_date' => $data->release_date,
                        'backdrop_path' => $data->backdrop_path,
                        'poster_path' => $data->poster_path,
                        'adult' => $data->adult,
                        'popularity' => $data->popularity,
                        'vote_average' => $data->vote_average,
                        'vote_count' => $data->vote_count,
                        'runtime' => $runtime
                    ]
                );

                // Sync genres with the movie
                $movie->genre()->sync($data->genre_ids);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to sync movies and genres', ['exception' => $e]);
        }
    }
}

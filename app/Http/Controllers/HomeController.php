<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\Promo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    function home()
    {
        $cinemas = Cinema::with([
            'auditorium' => function ($query) {
                $query->orderBy('name');
            }
        ])->get();
        $promos = Promo::all();
        $distinctMovieIds = MovieSchedule::whereBetween('date', [Carbon::now()->addDays(-1), Carbon::now()->addDays(7)])
            ->pluck('movie_id')
            ->unique();
        $movies = Movie::with(['genre'])
            ->whereIn('id', $distinctMovieIds)
            ->orderByDesc('release_date')
            ->get();


        return view('welcome', [
            'cinemas' => $cinemas,
            'promos' => $promos,
            'movies' => $movies,
        ]);
    }

    function movie(string $id)
    {
        $movie = Movie::with('genre')->findOrFail($id);
        $schedule = MovieSchedule::with(['auditorium.cinema'])
            ->whereBetween('date', [Carbon::now()->addDays(-1), Carbon::now()->addDays(7)])
            ->where(function ($query) {
                $query->where('date', '!=', Carbon::now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->where('date', Carbon::now()->toDateString())
                            ->where('show_start', '>', Carbon::now());
                    });
            })
            ->where('movie_id', $id)
            ->orderBy('date')
            ->get();

        return view('movie.detail', [
            'movie' => $movie,
            'schedule' => $schedule,
        ]);
    }

    function cinema(string $id)
    {
        $cinema = Cinema::with([
            'auditorium' => function ($query) {
                $query->orderBy('name');
            },
            'auditorium.movieSchedule' => function ($query) {
                $query->orderBy('date')->orderBy('show_start');
                $query->whereBetween('date', [Carbon::now()->addDays(-1), Carbon::now()->addDays(7)])
                    ->where(function ($query) {
                        $query->where('date', '!=', Carbon::now()->toDateString())
                            ->orWhere(function ($query) {
                                $query->where('date', Carbon::now()->toDateString())
                                    ->where('show_start', '>', Carbon::now());
                            });
                    });
            },
        ])->findOrFail($id);

        return view('cinema.detail', [
            'cinema' => $cinema,
        ]);
    }
}

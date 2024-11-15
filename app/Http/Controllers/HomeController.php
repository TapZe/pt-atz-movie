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
        $cinemas = Cinema::with('auditorium')->get();
        $promos = Promo::all();
        $distinctMovieIds = MovieSchedule::whereBetween('date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->pluck('movie_id')
            ->unique();
        $movies = Movie::with(['genre'])->whereIn('id', $distinctMovieIds)->orderByDesc('release_date')->get();


        return view('welcome', [
            'cinemas' => $cinemas,
            'promos' => $promos,
            'movies' => $movies,
        ]);
    }

    function movie(int $id)
    {
        $movie = Movie::with('genre')->findOrFail($id);
        $schedule = MovieSchedule::with(['auditorium.cinema']) // Eager load auditorium and cinema
            ->whereBetween('date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->where('movie_id', $id)
            ->get();
    }
}

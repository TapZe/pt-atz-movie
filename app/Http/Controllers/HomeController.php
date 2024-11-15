<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function home()
    {
        $cinemas = Cinema::with('auditorium')->get();
        $promos = Promo::all();
        $movies = Movie::with('genre')->limit(10)->orderByDesc('release_date')->get();

        return view('welcome', [
            'cinemas' => $cinemas,
            'promos' => $promos,
            'movies' => $movies,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MovieSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movieSchedules = MovieSchedule::with('movie', 'auditorium.cinema')->get();
        $groupedByCinema = $movieSchedules->groupBy(function ($movieSchedule) {
            return $movieSchedule->auditorium->cinema->name . ' - ' . $movieSchedule->auditorium->name;
        });
        $groupedMovieSchedule = $groupedByCinema->map(function ($schedules) {
            return $schedules->groupBy(function ($schedule) {
                return Carbon::parse($schedule->date)->format('Y-m-d'); // Group by date
            });
        });

        return view('admin.schedule.index', [
            'movieSchedules' => $movieSchedules,
            'groupedMovieSchedule' => $groupedMovieSchedule,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

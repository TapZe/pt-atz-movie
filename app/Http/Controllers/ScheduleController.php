<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\Seat;
use Illuminate\Http\Request;
use Schedule;

class ScheduleController extends Controller
{
    function schedule(string $id)
    {
        $schedule = MovieSchedule::with(['seat', 'movie'])->findOrFail($id);

        return view('schedule.detail', [
            'movie' => $schedule->movie,
            'schedule' => $schedule,
        ]);
    }

    function checkout(Request $request)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'schedule_id' => 'required|integer',
        ]);

        $schedule = MovieSchedule::with(['movie', 'auditorium', 'price'])->findOrFail($request->schedule_id);
        $seats = Seat::whereIn('id', $request->seats)->get();

        return view('checkout', compact('seats', 'movie'));
    }

    function bookSeats(Request $request, string $id)
    {
        return 0;
    }
}

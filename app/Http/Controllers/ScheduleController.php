<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\MovieScheduleSeat;
use App\Models\Promo;
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
            'schedule_id' => 'required|exists:movie_schedules,id',
        ]);

        $schedule = MovieSchedule::with(['movie', 'auditorium.cinema', 'price'])->findOrFail($request->schedule_id);
        $seats = Seat::whereIn('id', $request->seats)->get();

        return view('schedule.checkout', [
            'seats' => $seats,
            'schedule' => $schedule,
        ]);
    }

    function bookSeats(Request $request)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'schedule_id' => 'required|exists:movie_schedules,id',
        ]);

        $schedule = MovieSchedule::with([
            'movie',
            'auditorium.cinema',
            'price',
            'seat' => function ($query) use ($request) {
                $query->whereIn('seat_id', $request->seats);
            },
        ])->findOrFail($request->schedule_id);
        $alreadyBookedSeats = $schedule->seat->filter(function ($seat) {
            return $seat->pivot->booked;
        });

        if ($alreadyBookedSeats->isNotEmpty()) {
            $bookedSeatCodes = $alreadyBookedSeats->pluck('seat_code')->toArray();

            return redirect(route('schedule.detail', ['id' => $schedule->id]))
                ->withErrors([
                    'seats' => 'The following seats are already booked: ' . implode(', ', $bookedSeatCodes),
                ]);
        }

        foreach ($request->seats as $seatId) {
            $schedule->seat()->updateExistingPivot($seatId, [
                'user_id' => Auth()->id(),
                // for future if there is a payment gateway
                'payyed' => true,
                'payment_id' => 1,
            ]);
        }

        return redirect(route('profile.history'))->with([
            'message' => 'Seats booked successfully!',
        ]);
    }
}

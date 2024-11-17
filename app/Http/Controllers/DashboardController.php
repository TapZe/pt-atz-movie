<?php

namespace App\Http\Controllers;

use App\Models\MovieScheduleSeat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    function index()
    {
        $bookings = MovieScheduleSeat::with([
            'movieSchedule.movie',
            'movieSchedule.auditorium.cinema',
            'user'
        ])
            ->where('payyed', true)
            ->whereNotNull('user_id')
            ->whereHas('movieSchedule', function ($query) {
                $query->whereBetween('date', [Carbon::now()->addDays(-1), Carbon::now()->addDays(7)])
                    ->where(function ($query) {
                        $query->where('show_start', '>', Carbon::now())
                            ->orWhere(function ($query) {
                                $query->where('show_start', '<=', Carbon::now())
                                    ->where('show_end', '>=', Carbon::now());
                            });
                    });
            })
            ->get()
            ->groupBy(function ($booking) {
                return $booking->movieSchedule->auditorium->cinema->name; // Group by cinema
            })
            ->map(function ($cinemaGroup) {
                return $cinemaGroup->groupBy(function ($booking) {
                    return $booking->movieSchedule->auditorium->name; // Group by auditorium
                })->map(function ($auditoriumGroup) {
                    return $auditoriumGroup->groupBy(function ($booking) {
                        return $booking->movieSchedule->movie->title; // Group by movie title
                    });
                });
            });

        return view('dashboard', [
            'bookings' => $bookings
        ]);
    }

    function arrive($id)
    {
        $booking = MovieScheduleSeat::findOrFail($id);

        $booking->arrived = !$booking->arrived;
        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated.');
    }
}

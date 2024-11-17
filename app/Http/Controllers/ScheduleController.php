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
        $schedule = MovieSchedule::with([
            'seat' => function ($query) {
                $query->orderBy('seat_code');
            },
            'movie',
        ])->findOrFail($id);

        return view('schedule.detail', [
            'movie' => $schedule->movie,
            'schedule' => $schedule,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'schedule_id' => 'required|exists:movie_schedules,id',
            'promo_code' => 'nullable|string',
        ]);

        $message = '';
        $schedule = MovieSchedule::with(['movie', 'auditorium.cinema', 'price'])->findOrFail($request->schedule_id);
        $seats = Seat::whereIn('id', $request->seats)->get();

        // Default total price without discount
        $totalPrice = count($seats) * $schedule->price->number;

        $discount = 0;
        if ($request->filled('promo_code')) {
            // Check if promo code exists and is valid
            $promo = Promo::where('code', $request->promo_code)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if ($promo) {
                // Check if user has already used the promo code
                $userUsedPromo = $promo->user()->wherePivot('user_id', auth()->id())->exists();

                if (!$userUsedPromo) {
                    // Calculate discount based on promo type
                    if ($promo->type === 'percentage') {
                        $discount = $totalPrice * ($promo->discount / 100);
                    } elseif ($promo->type === 'fixed') {
                        $discount = $promo->discount;
                    }

                    // Ensure the discount does not exceed the total price
                    $discount = min($discount, $totalPrice);
                } else {
                    $message = "You have already used this promo code!";
                }
            } else {
                $message = 'Invalid promo code or expired.';
            }
        }

        // Final price after discount
        $finalPrice = $totalPrice - $discount;

        return view('schedule.checkout', [
            'seats' => $seats,
            'schedule' => $schedule,
            'totalPrice' => $totalPrice,
            'discount' => $discount,
            'finalPrice' => $finalPrice,
            'message' => $message
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

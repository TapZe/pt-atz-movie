<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\Price;
use App\Models\Seat;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Log;

class MovieScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::limit(10)->orderBy('release_date', 'desc')->get();
        $auditoria = Auditorium::with('cinema')->get();
        $movieCount = count($movies);
        $gap = 30; // Gap time in minutes
        $seats = Seat::all();
        $prices = Price::all();

        DB::beginTransaction();
        try {
            foreach ($auditoria as $index => $aud) {
                $movieIndex = $index % $movieCount;
                $openTime = Carbon::parse($aud->cinema->open_time);
                $closeTime = Carbon::parse($aud->cinema->close_time);

                // Loop through the next 7 days
                for ($i = 0; $i < 7; $i++) {
                    $date = Carbon::now()->addDays($i);

                    // Check if a schedule for this date already exists for this auditorium
                    $existingSchedules = MovieSchedule::where('auditorium_id', $aud->id)
                        ->whereDate('date', $date->toDateString())
                        ->exists();
                    if ($existingSchedules) {
                        continue;
                    }

                    // Reset openTime to cinema's open time at the start of each day
                    $currentOpenTime = $openTime->copy();

                    while ($currentOpenTime->copy()->addMinutes($movies[$movieIndex]->runtime) <= $closeTime) {
                        // End time of the show and round it to the next five minutes
                        $showEnd = $this->roundToNextFiveMinutes($currentOpenTime->copy()->addMinutes($movies[$movieIndex]->runtime));

                        // Determine price based on weekday/weekend (this is the default)
                        $priceId = $prices[$date->isWeekday() ? 0 : 1]->id;

                        $created = MovieSchedule::create([
                            'date' => $date->toDateString(),
                            'show_start' => $currentOpenTime->toTimeString(),
                            'show_end' => $showEnd->toTimeString(),
                            'price_id' => $priceId,
                            'movie_id' => $movies[$movieIndex]->id,
                            'auditorium_id' => $aud->id,
                        ]);
                        $created->seat()->sync($seats);

                        // Move openTime forward by runtime + gap, then round to the next five minutes
                        $currentOpenTime->addMinutes($movies[$movieIndex]->runtime + $gap);
                        $currentOpenTime = $this->roundToNextFiveMinutes($currentOpenTime);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add the movie schedule automatically', ['exception' => $e]);
        }
    }

    private function roundToNextFiveMinutes($time)
    {
        $minute = $time->minute;
        $roundedMinute = ceil($minute / 5) * 5;
        if ($roundedMinute == 60) {
            $time->addHour()->minute(0);
        } else {
            $time->minute($roundedMinute);
        }
        return $time;
    }
}

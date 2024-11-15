<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateMovieScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-movie-schedule-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily update the database movie schedule and it\'s seat for the next 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => 'MovieScheduleSeeder']);
        $this->info('MovieScheduleSeeder have been run successfully!');
    }
}

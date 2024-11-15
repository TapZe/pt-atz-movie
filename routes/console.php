<?php

use App\Console\Commands\UpdateMovieCommand;
use App\Console\Commands\UpdateMovieScheduleCommand;

Schedule::command(UpdateMovieCommand::class)->dailyAt('08:30');
Schedule::command(UpdateMovieScheduleCommand::class)->dailyAt('08:35');

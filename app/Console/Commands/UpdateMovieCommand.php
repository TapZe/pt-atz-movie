<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateMovieCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-movie-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily update the database movies and genres from the third app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => 'MovieSeeder']);
        $this->call('db:seed', ['--class' => 'GenreSeeder']);
        $this->info('MovieSeeder and GenreSeeder have been run successfully!');
    }
}

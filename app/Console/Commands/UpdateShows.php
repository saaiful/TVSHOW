<?php

namespace App\Console\Commands;

use App\Show;
use Illuminate\Console\Command;

class UpdateShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Shows';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shows = Show::all();
        foreach ($shows as $key => $show) {
            echo ($key + 1) . " > " . $show->tvmaze($show->id) . "\n";
        }
    }
}

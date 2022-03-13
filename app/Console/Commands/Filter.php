<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Filter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Filter Show';

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
        $files = scandir(env('DIR'));
        foreach ($files as $key => $file) {
            if (preg_match("/(.*)\.(mp4|mkv|avi)$/", $file, $m)) {
                var_dump($file);
                var_dump($m);
            }
        }
    }
}

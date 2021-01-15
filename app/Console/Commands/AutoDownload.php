<?php

namespace App\Console\Commands;

use App\Episode;
use Illuminate\Console\Command;

class AutoDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download Shows Auto';

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
        $date = date('Y-m-d', strtotime('-8 hour'));
        $items = Episode::with('show')->whereDate('schedule', $date)->whereNull('magnet')->get();
        if (!$items) {
            echo '**all done**';
            return true;
        }
        foreach ($items as $key => $item) {
            file_get_contents(url('download?id=' . $item->id . '&download=yes&force=yes'));
        }
        echo '**ok**';
        return true;
    }
}

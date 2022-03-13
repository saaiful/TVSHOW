<?php

namespace App\Console\Commands;

use App\Episode;
use File;
use Illuminate\Console\Command;

class PlexStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plex:style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename Show in Plex Format';

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
     * Get Recursive Dir with Media File
     * @param  [type] $path   [description]
     * @param  array  $branch [description]
     * @return [type]         [description]
     */
    private function getTree($path, $branch = [])
    {
        if (!file_exists($path)) {
            return [];
        }

        $tree = [];

        foreach (File::files($path) as $file) {
            if (preg_match("/S[0-9]{1,3}E[0-9]{1,3}.*\.(mkv|mp4|avi|webm)$/i", $file, $m)) {
                $file_path = $path . DIRECTORY_SEPARATOR . basename($file);
                $branch[]  = [$file_path, $m[1], time() - filemtime($file_path)];
            }
        }

        foreach (File::directories($path) as $directory) {
            $branch = $this->getTree($directory, $branch);
        }

        return array_merge($tree, $branch);
    }

    /**
     * Make Recursive Dir
     * @param  [type]  $path        [description]
     * @param  integer $permissions [description]
     * @return [type]               [description]
     */
    private function make_dir($path, $permissions = 0777)
    {
        return is_dir($path) || mkdir($path, $permissions, true);
    }

    /**
     * Windows Safe File Name
     * @param  [type] $unsafeFilename [description]
     * @return [type]                 [description]
     */
    public function filename_sanitizer($unsafeFilename)
    {
        $dangerousCharacters = ['<', '>', ':', '"', '/', '\\', '|', '?', '*'];
        $safe_filename       = str_replace($dangerousCharacters, '', $unsafeFilename);
        return $safe_filename;
    }

    /**
     * Delete Folder
     * @param  [type] $dir [description]
     * @return [type]      [description]
     */
    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $items = Episode::with('show')->where('status', 1)->get();
        foreach ($items as $item_key => $item) {
            $dir   = $main_dir   = str_replace(["//"], DIRECTORY_SEPARATOR, env('DIR') . DIRECTORY_SEPARATOR . $item->id);
            $shows = $this->getTree($dir);
            if (count($shows) > 0) {
                if ($shows[0][2] > 20) {
                    $year                = ($item->show->premiered) ? date(' (Y)', strtotime($item->show->premiered)) : '';
                    $show_with_year      = $this->filename_sanitizer($item->show->name . $year);
                    $show_with_year_tpdb = $show_with_year . ' {tvdb-' . $item->show->thetvdb . '}';
                    $new_dir             = str_replace("/", DIRECTORY_SEPARATOR, env('FINAL_DIR') . DIRECTORY_SEPARATOR . $show_with_year_tpdb . DIRECTORY_SEPARATOR . 'Season ' . sprintf("%02d", $item->season));
                    $new_name            = $new_dir . DIRECTORY_SEPARATOR . $show_with_year . ' - ' . sprintf("s%02de%02d", $item->season, $item->episode) . ' - ' . $item->name . '.' . $shows[0][1];
                    // var_dump($new_dir);
                    $this->make_dir($new_dir);
                    @rename($shows[0][0], $new_name);
                    $this->delTree($main_dir);
                    echo "**ok**\n";
                    $item->status = 2;
                    $item->save();
                } else {
                    echo "Wait: " . $shows[0][2] . "\n";
                }
            } else {
                echo "**na**\n";
            }
        }
    }
}

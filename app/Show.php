<?php

namespace App;

use App\Episode;
use Curl;
use DB;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tvmaze_id', 'imdb_id', 'genres', 'name', 'search', 'match', 'summary', 'schedule', 'cover', 'season', 'episode', 'p_episode', 'n_episode', 'last_update', 'thetvdb', 'premiered'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['genres' => 'array'];

    /**
     * Fetch Data From TVMAZE
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function tvmaze($id)
    {
        $ids = DB::table('episodes')->select('tvmaze_id')
            ->selectRaw('count(`tvmaze_id`) as `occurences`')
            ->groupBy('tvmaze_id')
            ->having('occurences', '>', 1)
            ->get()->pluck('tvmaze_id');

        $show = Show::find($id);
        if (!$show) {
            return '**no-show**';
        }

        $url  = "http://api.tvmaze.com/shows/{$show->tvmaze_id}?embed=episodes";
        $ch   = new Curl();
        $data = json_decode($ch->get($url));
        $pre  = str_replace("http://api.tvmaze.com/episodes/", '', @$data->_links->previousepisode->href);
        $nxt  = str_replace("http://api.tvmaze.com/episodes/", '', @$data->_links->nextepisode->href);
        if ($data) {
            $show = Show::where('tvmaze_id', $data->id)->first();
            if (!$show) {
                $show = new Show();
            }
            $show->tvmaze_id = $data->id;
            $show->name      = $data->name;
            $show->summary   = $data->summary;
            $show->schedule  = $data->schedule->time;
            $show->cover     = $data->image->original;
            $show->premiered = $data->premiered;
            $show->thetvdb   = $data->externals->thetvdb;
            $show->p_episode = $pre;
            $show->n_episode = $nxt;
            $show->save();
            Episode::whereIn('tvmaze_id', $ids)->where('show_id', $show->id)->delete();
            $ep = 0;
            foreach ($data->_embedded->episodes as $key => $value) {
                $ep += 1;
                $s = $value->season;
                $x = Episode::where('tvmaze_id', $value->id)->first();
                if (!$x) {
                    $x = new Episode();
                }
                $x->tvmaze_id = $value->id;
                $x->show_id   = $show->id;
                $x->season    = $value->season;
                $x->episode   = $value->number;
                $x->summary   = $value->summary;
                $x->name      = $value->name;
                $x->schedule  = $value->airdate . " " . $show->schedule;
                $x->save();
            }
            $show->episode = $ep;
            $show->season  = $s;
            $show->save();
            return "**" . $show->name . '**ok**';
        }
        return '**error**';
    }
}

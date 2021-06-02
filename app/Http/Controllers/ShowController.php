<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Show;
use Curl;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->q) {
            $items = Show::where('name', 'LIKE', '%' . $request->q . '%')->paginate('10');
        } else {
            $items = Show::paginate('10');
        }
        return view('show.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('show.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id   = $request->id;
        $url  = "http://api.tvmaze.com/shows/{$id}?embed=episodes";
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
            $show->imdb_id   = $data->externals->imdb;
            $show->name      = $data->name;
            $show->summary   = $data->summary;
            $show->schedule  = $data->schedule->time;
            $show->cover     = $data->image->original;
            $show->p_episode = $pre;
            $show->n_episode = $nxt;
            $show->genres    = $data->genres;
            $show->save();
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
                $x->name      = $value->name;
                $x->schedule  = $value->airdate;
                $x->summary   = $value->summary;
                $x->save();
            }
            $show->episode = $ep;
            $show->season  = $s;
            $show->save();
            return redirect('/')->with('success', 'New Show "' . $show->name . '" Added!');
        }
        return redirect('/')->with('error', 'Something Went Wrong!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function show(Show $show)
    {
        $last = Episode::where('show_id', $show->id)
            ->whereDate('schedule', '<=', date('Y-m-d', strtotime('-8 hour')))
            ->whereDate('schedule', '!=', '0000-00-00')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $seasons = Episode::where('show_id', $show->id)
            ->groupBy('season')
            ->orderBy('season', 'desc')
            ->get();

        return view('show.show')
            ->with('show', $show)
            ->with('last', $last)
            ->with('seasons', $seasons);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function edit(Show $show)
    {
        return view('show.edit')->with('show', $show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Show $show)
    {
        $show->search = $request->search;
        $show->save();
        return redirect('/show/' . $show->id)->with('success', 'Details Updated!');
    }

    /**
     * Fetch Show Data
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function fetch(Request $request, $id)
    {
        $show   = new Show();
        $result = $show->tvmaze($id);
        if (preg_match("/error/", $result)) {
            if ($request->ajax()) {
                return ['**error**'];
            }
            return redirect()->back()->with('error', 'Something Went Wrong!');
        } else {
            if ($request->ajax()) {
                return ['**ok**'];
            }
            return redirect()->back()->with('success', 'Show information updated!');
        }
    }

    /**
     * Show Update All Page
     * @return [type] [description]
     */
    public function updateAll()
    {
        $shows = Show::all();
        return view('update_all')->with('shows', $shows);
    }

    /**
     * Show Auto Download Page
     * @return [type] [description]
     */
    public function autoDownload()
    {
        $date  = date('Y-m-d', strtotime('-8 hour'));
        $items = Episode::with('show')->whereDate('schedule', $date)->whereNull('magnet')->get();
        if (!$items) {
            return '**all done**';
        }
        foreach ($items as $key => $item) {
            @file_get_contents(url('download?id=' . $item->id . '&download=yes'));
        }
        return '**ok**';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function destroy(Show $show)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Show;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show Home Page
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function home(Request $request)
    {
        $day_of_week = date('N');
        $given_date = strtotime(date('Y-m-d', strtotime('-1 day')));
        $first_of_week = date('Y-m-d', strtotime("- {$day_of_week} day", $given_date));
        $first_of_week = strtotime($first_of_week);
        for ($i = 0; $i < 7; $i++) {
            $week_array[] = date('Y-m-d', strtotime("+ {$i} day", $first_of_week));
        }
        $items = [];
        foreach ($week_array as $key => $date) {
            $items[strtoupper(date('D', strtotime($date)))] = Episode::with('show')->whereDate('schedule', $date)->get();
        }
        return view('home')->with('items', $items);
    }

    /**
     * Show Downloading Page
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloading(Request $request)
    {
        return view('downloading');
    }

    /**
     * Show Whats New
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function whatsNew(Request $request)
    {
        $date = date('Y-m-d', strtotime('-1 day'));
        $items = Episode::with('show')->whereDate('schedule', $date)->get();
        return view('whats-new')->with('items', $items);
    }
}

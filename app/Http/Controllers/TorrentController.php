<?php

namespace App\Http\Controllers;

use App\Episode;
use Aria2;
use Curl;
use Illuminate\Http\Request;

class TorrentController extends Controller
{
    public $errors = [];

    public $ts = 'ettv|eztv|hdtv|rartv|TGx|WEB|H\.246';

    /**
     * The Pirate Bay Driver
     * @param  string $search
     * @param  string $match
     * @return array result
     */
    public function tpb($search, $match)
    {
        // return false;
        $ch   = new Curl();
        $url  = 'https://piratebay.party/search/' . rawurlencode($search) . '/1/99/0';
        $html = $ch->get($url, 'https://piratebay.party/search/');
        // return $url;
        if (!$html) {
            $this->errors[] = 'TPB Down';
            return false;
        }
        $html = str_get_html($html);
        $x    = [];
        $regx = "/^" . $match . ".*({$this->ts})/i";
        foreach ($html->find("tbody tr") as $key => $value) {
            $a = @$value->find('th, td', 1)->innertext;
            if ($a) {
                $name = @$value->find('th, td', 1)->find('a', 0)->innertext;
                $seed = @$value->find('th, td', 5)->innertext;
                $mgnt = @$value->find('th, td', 3)->find('a', 0)->href;
                // var_dump($name);
                // var_dump($regx);
                // var_dump($mgnt);
                if (preg_match($regx, $name)) {
                    $x[] = ['seed' => $seed, 'name' => $name, 'url' => $mgnt];
                }
            }
        }
        return (isset($x[0])) ? $x[0] : false;
    }

    /**
     * 1337x Driver
     * @param  string $search
     * @param  string $match
     * @return array result
     */
    public function l33t($search, $match)
    {
        $ch   = new Curl();
        $html = $ch->get('https://1337x.to/search/' . urlencode($search) . "/1/");
        // return 'https://1337x.unblockit.id/search/' . urlencode($search) . "/1";
        $html = str_get_html($html);

        if (!$html) {
            $this->errors[] = '1337x Down';
            return false;
        }
        $x = [];
        foreach ($html->find(".table-list tr") as $key => $value) {
            $_x = @$value->find('a')[1]->innertext;
            if ($_x && preg_match("/" . $match . ".*({$this->ts})/i", $_x)) {
                $_y  = @$value->find('a')[1]->href;
                $_z  = (int) @$value->find('.seeds')[1]->innertext;
                $x[] = ['seed' => $_z, 'name' => $_x, 'url' => $_y];
            }
        }
        if (isset($x[0])) {
            $link = "https://1337x.to" . $x[0]['url'];
            // return $link;
            $result = $ch->get($link);
            $html   = str_get_html($result);
            if (!$html) {
                return response()->json("Try Again!", 500);
            }
            $magnet      = @$html->find('.page-content ul li a')[0]->href;
            $x[0]['url'] = $magnet;
            return $x[0];
        }
        return false;
    }

    /**
     * KickAss Driver
     * @param  string $search
     * @param  string $match
     * @return array result
     */
    public function kat($search, $match)
    {
        $ch   = new Curl();
        $html = $ch->get('https://kickass.cd/torrent/usearch/' . urlencode($search));
        $html = str_get_html($html);
        if (!$html) {
            $this->errors[] = 'KAT Down';
            return false;
        }
        $x = [];
        foreach ($html->find('tbody tr') as $key => $value) {
            $_x = trim(@$value->find('.cellMainLink')[0]->plaintext);
            $_y = "https://kickass.cd" . @$value->find('.cellMainLink')[0]->href;
            $_z = @$value->find('td')[4]->innertext;
            if (!preg_match("/Y/", $_z) && preg_match("/" . $match . ".*({$this->ts})/i", $_x)) {
                $x[] = ['seed' => (int) $_z, 'name' => $_x, 'url' => $_y];
            }
        }
        if (isset($x[0])) {
            $html        = $ch->get($x[0]['url']);
            $html        = str_get_html($html);
            $x[0]['url'] = @$html->find('.kaGiantButton')[0]->href;
        }
        return (isset($x[0])) ? $x[0] : false;
    }

    /**
     * Start Aria 2 Download
     * @param  [type] $uri [description]
     * @return bool
     */
    public function startDownload($uri, $show)
    {
        // dd(base_path('basic.cmd'));
        if (env('DOWNLOAD')) {
            $aria2 = new Aria2();
            try {
                $aria2->addUri([$uri], [
                    'dir'       => str_replace("//", "/", env('DIR') . '/' . $show),
                    'seed-time' => env('SEED'),
                    'x'         => 2,
                ]);
                Episode::where('id', $show)->update(['status' => 1]);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Aria2 Status
     * @return [type] [description]
     */
    public function aria2status()
    {
        if (!env('DOWNLOAD')) {return abort(404);}
        $aria2       = new Aria2();
        $paused      = $aria2->tellWaiting(0, 1000);
        $paused      = @$paused['result'];
        $r           = $aria2->tellActive();
        $running     = @$r['result'];
        $r['result'] = [];
        foreach ($running as $key => $value) {
            $r['result'][] = $value;
        }
        foreach ($paused as $key => $value) {
            $r['result'][] = $value;
        }
        return response()->json($r, 200);
    }

    /**
     * Aria2 Remove Torrent
     * @return [type] [description]
     */
    public function aria2remove()
    {
        if (!env('DOWNLOAD')) {return abort(404);}
        $aria2 = new Aria2();
        $aria2->remove(@$_GET['id']);
        return redirect('/downloading');
    }

    /**
     * Aria2 Pause Torrent
     * @return [type] [description]
     */
    public function aria2pause()
    {
        if (!env('DOWNLOAD')) {return abort(404);}
        $aria2 = new Aria2();
        $aria2->pause(@$_GET['id']);
        return redirect('/downloading');
    }

    /**
     * Aria2 Resume Torrent
     * @return [type] [description]
     */
    public function aria2resume()
    {
        if (!env('DOWNLOAD')) {return abort(404);}
        $aria2 = new Aria2();
        $aria2->unpause(@$_GET['id']);
        return redirect('/downloading');
    }

    /**
     * Search & Download Torrent
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function download(Request $request)
    {

        $output = ['result' => false];
        $item   = Episode::find($request->id);

        if ($item) {
            $__s    = ($item->show->search) ? $item->show->search : $item->show->name;
            $__s    = str_replace([":"], [' '], $__s);
            $search = sprintf("%s S%02dE%02d", $__s, $item->season, $item->episode);

            $sae = sprintf("%s.*S%02dE%02d", $__s, $item->season, $item->episode);
            $sae = str_replace(" ", '[\s\.]+', $sae);
            if (empty($item->magnet) || $request->force == 'yes') {
                $result = $this->tpb($search, $sae);

                if (!$result) {
                    $result = $this->l33t($search, $sae);
                }

                if (!$result) {
                    $result = $this->kat($search, $sae);
                }
                if ($result) {
                    $output['result'] = $result;
                    $item->magnet     = $result['url'];
                    $item->save();
                    if ($request->download == 'yes') {
                        if ($this->startDownload($item->magnet, $item->id)) {
                            $output['download'] = true;
                        } else {
                            $output['download'] = true;
                        }
                    }
                }
                $output['errors'] = $this->errors;
                if ($output['result'] == false) {
                    return redirect()->back()->with('error', 'Can\'t Find The Show!');
                }
                return redirect()->back()->with('success', 'Downloading ' . $search . " Now!");
                return response()->json($output, 201);
            } else {
                $output['errors']         = false;
                $output['result']['url']  = $item->magnet;
                $output['result']['seed'] = -1;
                $output['result']['name'] = 'No Idea';
                if ($request->download == 'yes') {
                    if ($this->startDownload($item->magnet, $item->id)) {
                        $output['download'] = true;
                    } else {
                        $output['download'] = true;
                    }
                }
                if ($output['result'] == false) {
                    return redirect()->back()->with('error', 'Can\'t Find The Show!');
                }

                return redirect()->back()->with('success', 'Downloading ' . $search . " Now!");
                return response()->json($output, 200);
            }
        } else {
            return redirect()->back()->with('error', 'Show not found');
            return response()->json('Not Found', 404);
        }
    }
}

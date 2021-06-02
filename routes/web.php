<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'PageController@home');
// Route::get('/show/{id}', 'PageController@show');
Route::get('/whats-new', 'PageController@whatsNew');
Route::get('/downloading', 'PageController@downloading');
Route::get('/download', 'TorrentController@download');
Route::get('/aria2-ajax', 'TorrentController@aria2status');
Route::get('/aria2/remove', 'TorrentController@aria2remove');
Route::get('/aria2/pause', 'TorrentController@aria2pause');
Route::get('/aria2/resume', 'TorrentController@aria2resume');

Route::get('show/auto-download', 'ShowController@autoDownload');
Route::get('show/update-all', 'ShowController@updateAll');
Route::get('show/{id}/fetch', 'ShowController@fetch');
Route::resource('show', 'ShowController');

// Route::get('/test', 'TorrentController@search');
/*Route::get('/test', function () {
$shows = App\Show::all();
foreach ($shows as $key => $show) {
$url = "http://api.tvmaze.com/shows/{$show->tvmaze_id}?embed=episodes";
$ch = new Curl();
$data = json_decode($ch->get($url));
$show->imdb_id = $data->externals->imdb;
$show->genres = $data->genres;
$show->save();
}
return '**ok**';
});
 */

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tvmaze_id', 'imdb_id', 'genres', 'name', 'search', 'match', 'summary', 'schedule', 'cover', 'season', 'episode', 'p_episode', 'n_episode', 'last_update'];

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
}

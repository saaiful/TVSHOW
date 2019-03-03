<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tvmaze_id', 'show_id', 'season', 'episode', 'name', 'summary', 'schedule', 'magnet'];

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
    protected $casts = [];

    /**
     * Get the show record associated with the record.
     */
    public function show()
    {
        return $this->hasOne('App\Show', 'id', 'show_id');
    }

}

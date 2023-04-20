<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
    public function details_genres()
    {
        return $this->hasMany('App\Models\Details_genre', 'movie_id', 'id');
    }
    public function countries()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany('App\Models\Comment', 'movie_id', 'id');
    }
    public function espisode()
    {
        return $this->hasMany('App\Models\Espisode','movie_id','id');
    }

    public function paid_movies()
    {
        return $this->hasMany('App\Models\Paid_movie','movie_id','id');
    }

    public function trailer()
    {
        return $this->hasMany('App\Models\Trailer','movie_id','id');
    }
}

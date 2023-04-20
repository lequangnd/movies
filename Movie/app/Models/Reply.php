<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table='reply';
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function social()
    {
        return $this->belongsTo('App\Models\Social','provider_id','provider_id');
    }

    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like','reply_id','id');
    }
}

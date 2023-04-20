<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table='social';

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\Level','level_id','id');
    }
}

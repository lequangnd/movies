<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public function movies()
    {
        return $this->hasMany('App\Models\Movie', 'country_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'log_id';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    public function loggable()
    {
        return $this->morphTo();
    }
}

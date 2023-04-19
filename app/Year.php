<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $primaryKey = 'year_id';

    public function statistics()
    {
        return $this->hasMany('App\Statistic', 'year_id', 'year_id');
    }
}

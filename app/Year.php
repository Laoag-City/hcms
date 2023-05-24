<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $primaryKey = 'year_id';

    protected $fillable = ['year'];

    public function statistics()
    {
        return $this->hasMany('App\Statistic', 'year_id', 'year_id');
    }

    public function getCurrentYear()
    {
        return $this->firstOrCreate(['year' => date('Y', strtotime('now'))]);
    }

    public function getYear($year)
    {
        return $this->firstOrCreate(['year' => $year]);
    }
}

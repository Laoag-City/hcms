<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $primaryKey = 'statistic_id';

    public function document_category()
    {
        return $this->belongsTo('App\DocumentCategory', 'document_category_id', 'document_category_id');
    }

    public function year()
    {
        return $this->belongsTo('App\Year', 'year_id', 'year_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $primaryKey = 'statistic_id';

    protected $fillable = ['document_category_id', 'year_id', 'count'];

    public function document_category()
    {
        return $this->belongsTo('App\DocumentCategory', 'document_category_id', 'document_category_id');
    }

    public function year()
    {
        return $this->belongsTo('App\Year', 'year_id', 'year_id');
    }

    public function recordOne($category, $year, $add)
    {
        $statistic = $this->firstOrNew(['document_category_id' => $category, 'year_id' => $year]);

        if($add)
            $statistic->counts = $statistic->counts + 1;

        else
            $statistic->counts = $statistic->counts - 1;

        $statistic->save();
    }
}

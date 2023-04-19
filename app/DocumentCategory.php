<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $primaryKey = 'document_category_id';

    public function document_type()
    {
        return $this->belongsTo('App\DocumentType', 'document_type_id', 'document_type_id');
    }

    public function statistics()
    {
        return $this->hasMany('App\Statistic', 'document_category_id', 'document_category_id');
    }
}

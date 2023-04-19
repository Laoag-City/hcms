<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $primaryKey = 'document_type_id';

    public function document_categories()
    {
        return $this->hasMany('App\DocumentCategory', 'document_type_id', 'document_type_id');
    }
}

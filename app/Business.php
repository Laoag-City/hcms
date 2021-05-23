<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Business extends Model
{
    use Eloquence;

    protected $primaryKey = 'business_id';
    protected $searchableColumns = ['business_name'];

    public function sanitary_permits()
    {
        return $this->hasMany('App\SanitaryPermit', 'business_id', 'business_id');
    }
}

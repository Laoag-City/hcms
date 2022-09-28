<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;

class StoolAndOther extends Model
{
	use DateToInputFormatter;
	
    protected $primaryKey = 'stool_and_other_id';

    public function health_certificate()
    {
    	return $this->belongsTo('App\HealthCertificate', 'health_certificate_id', 'health_certificate_id');
    }

    public function pink_health_certificate()
    {
        return $this->belongsTo('App\PinkHealthCertificate', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function getDateAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function dateToInput($attribute)
    {
        return $this->convertDateForInputField($this->attributes[$attribute]);
    }
}

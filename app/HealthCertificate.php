<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;

class HealthCertificate extends Model
{
    use DateToInputFormatter;

    protected $primaryKey = 'health_certificate_id';

    public function applicant()
    {
    	return $this->belongsTo('App\Applicant', 'applicant_id', 'applicant_id');
    }

    public function immunizations()
    {
    	return $this->hasMany('App\Immunization', 'health_certificate_id', 'health_certificate_id');
    }

    public function stool_and_others()
    {
    	return $this->hasMany('App\StoolAndOther', 'health_certificate_id', 'health_certificate_id');
    }

    public function xray_sputums()
    {
    	return $this->hasMany('App\XRaySputum', 'health_certificate_id', 'health_certificate_id');
    }

    public function getIssuanceDateAttribute($value)
    {
        return date('M. d, Y', strtotime($value));
    }

    public function getExpirationDateAttribute($value)
    {
        return date('M. d, Y', strtotime($value));
    }

    public function dateToInput($attribute)
    {
        return $this->convertDateForInputField($this->attributes[$attribute]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;
use Sofa\Eloquence\Eloquence;
use App\Custom\ExpirationChecker;

class HealthCertificate extends Model
{
    use DateToInputFormatter;
    use Eloquence;
    use ExpirationChecker;

    protected $primaryKey = 'health_certificate_id';
    public const DATES_FORMAT = 'M d, Y';
    public const CERTIFICATE_TYPES = [
        'Yellow' => [
            'string' => '6 months',
            'years' => 0,
            'months' => 6,
            'days' => 0
        ],
        'Green' => [
            'string' => '1 year',
            'years' => 1,
            'months' => 0,
            'days' => 0
        ]
    ];

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
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function getExpirationDateAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function dateToInput($attribute)
    {
        return $this->convertDateForInputField($this->attributes[$attribute]);
    }

    public function getColor()
    {
        return strtolower(collect(self::CERTIFICATE_TYPES)->where('string', $this->duration)->keys()->first());
    }

    public function checkIfExpired()
    {
        return $this->checkExpiration($this->attributes['expiration_date'], $this->is_expired);
    }
}

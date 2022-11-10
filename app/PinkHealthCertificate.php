<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;
use Sofa\Eloquence\Eloquence;
use App\Custom\ExpirationChecker;

class PinkHealthCertificate extends Model
{
    use DateToInputFormatter;
    use Eloquence;
    use ExpirationChecker;

    protected $primaryKey = 'pink_health_certificate_id';
    public const DATES_FORMAT = 'M d, Y';
    public const VALIDITY_PERIOD = [
            'string' => '6 months',
            'years' => 0,
            'months' => 6,
            'days' => 0
        ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant', 'applicant_id', 'applicant_id');
    }

    public function immunizations()
    {
        return $this->hasMany('App\Immunization', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function xray_sputums()
    {
        return $this->hasMany('App\XRaySputum', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function stool_and_others()
    {
        return $this->hasMany('App\StoolAndOther', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function hiv_examinations()
    {
        return $this->hasMany('App\HivExamination', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function hbsag_examinations()
    {
        return $this->hasMany('App\HbsagExamination', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function vdrl_examinations()
    {
        return $this->hasMany('App\VdrlExamination', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function cervical_smear_examinations()
    {
        return $this->hasMany('App\CervicalSmearExamination', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'loggable');
    }

    public function getIssuanceDateAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function getExpirationDateAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function getCommunityTaxIssuedOnAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function dateToInput($attribute)
    {
        return $this->convertDateForInputField($this->attributes[$attribute]);
    }

    public function checkIfExpired()
    {
        return $this->checkExpiration($this->attributes['expiration_date'], $this->is_expired);
    }
}

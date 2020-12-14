<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;

class HealthCertificate extends Model
{
    use DateToInputFormatter;

    protected $primaryKey = 'applicant_id';
    public $incrementing = false;
    public const DATES_FORMAT = 'M. d, Y';
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
    	return $this->hasMany('App\Immunization', 'applicant_id', 'applicant_id');
    }

    public function stool_and_others()
    {
    	return $this->hasMany('App\StoolAndOther', 'applicant_id', 'applicant_id');
    }

    public function xray_sputums()
    {
    	return $this->hasMany('App\XRaySputum', 'applicant_id', 'applicant_id');
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
        if(strtotime('now') >= strtotime($this->attributes['expiration_date']))
        {
            if($this->is_expired == false)
            {
                $this->is_expired = true;
                $this->save();
            }

            return true;
        }

        else
        {
            if($this->is_expired == true)
            {
                $this->is_expired = false;
                $this->save();
            }

            return false;
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanitaryPermit extends Model
{
    protected $primaryKey = 'sanitary_permit_id';
    public const DATES_FORMAT = 'M. d, Y';

    public function applicant()
    {
    	return $this->belongsTo('App\Applicant', 'applicant_id', 'applicant_id');
    }

    public function getIssuanceDateAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
    }

    public function getExpirationDateAttribute($value)
    {
        return date(self::DATES_FORMAT, strtotime($value));
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

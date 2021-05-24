<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;

class SanitaryPermit extends Model
{
	use DateToInputFormatter;

    protected $primaryKey = 'sanitary_permit_id';
    public const DATES_FORMAT = 'M d, Y';

    public function applicant()
    {
    	return $this->belongsTo('App\Applicant', 'applicant_id', 'applicant_id');
    }

    public function business()
    {
        return $this->belongsTo('App\Business', 'business_id', 'business_id');
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

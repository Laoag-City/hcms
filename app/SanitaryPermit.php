<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;
use Sofa\Eloquence\Eloquence;
use App\Custom\ExpirationChecker;

class SanitaryPermit extends Model
{
	use DateToInputFormatter;
    use Eloquence;
    use ExpirationChecker;

    protected $primaryKey = 'sanitary_permit_id';
    public const DATES_FORMAT = 'M d, Y';
    public const PERMIT_CLASSIFICATIONS = [
                                            'Food',
                                            'Non-food',
                                            'Industrial'
                                        ];

    public function applicant()
    {
    	return $this->belongsTo('App\Applicant', 'applicant_id', 'applicant_id');
    }

    public function business()
    {
        return $this->belongsTo('App\Business', 'business_id', 'business_id');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'loggable');
    }

    public function getAddressAttribute()
    {
        if($this->brgy && $this->street)
            return "BRGY. {$this->brgy} {$this->street}, LAOAG CITY";

        elseif($this->brgy && !$this->street)
            return "BRGY. {$this->brgy}, LAOAG CITY";

        else if(!$this->brgy && $this->street)
            return "{$this->street}, LAOAG CITY";

        else
            return "LAOAG CITY";
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

    public function getRegisteredName()
    {
        if($this->applicant != null)
            return $this->applicant->formatName();
        elseif($this->business != null)
            return $this->business->business_name;
        else
            return '';
    }

    public function checkIfExpired()
    {
        return $this->checkExpiration($this->attributes['expiration_date'], $this->is_expired);
    }
}

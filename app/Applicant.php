<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Applicant extends Model
{
	use Eloquence;

    protected $primaryKey = 'applicant_id';
    protected $searchableColumns = ['first_name', 'middle_name', 'last_name', 'suffix_name'];

    public function health_certificate()
    {
    	return $this->hasOne('App\HealthCertificate', 'applicant_id', 'applicant_id');
    }

    public function sanitary_permits()
    {
        return $this->hasMany('App\SanitaryPermit', 'applicant_id', 'applicant_id');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = title_case($value);
    }

    public function setMiddleNameAttribute($value)
    {
        if($value != null)
            $this->attributes['middle_name'] = title_case($value);
        else
            $this->attributes['middle_name'] = null;
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = title_case($value);
    }

    public function formatName()
	{
		return trim(preg_replace('!\s+!', ' ', "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix_name}"));
	}

    public function getGender()
    {
        return $this->gender == 1 ? 'Male' : 'Female';
    }
}

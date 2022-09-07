<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\DateToInputFormatter;

class CervicalSmearExamination extends Model
{
    use DateToInputFormatter;

    protected $primaryKey = 'cervical_smear_examination_id';

    public function pink_health_certificate()
    {
        return $this->belongsTo('App\PinkHealthCertificate', 'pink_health_certificate_id', 'pink_health_certificate_id');
    }

    public function getDateOfExamAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function getDateOfNextExamAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function dateToInput($attribute)
    {
        return $this->convertDateForInputField($this->attributes[$attribute]);
    }
}

<?php

namespace App\Custom;

trait ExpirationChecker
{
	abstract public function checkIfExpired($expiration_date, $is_expired);

	public function checkExpiration($expiration_date, $is_expired)
    {
        if(strtotime('now') >= strtotime($expiration_date))
        {
            if($is_expired == false)
            {
                $is_expired = true;
                $this->save();
            }

            return true;
        }

        else
        {
            if($is_expired == true)
            {
                $is_expired = false;
                $this->save();
            }

            return false;
        }
    }
}

?>
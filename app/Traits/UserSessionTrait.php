<?php
/**
 * Created by PhpStorm.
 * User: chandan
 * Date: 18/7/17
 * Time: 12:59 PM
 */

namespace App\Traits;

use Auth;

trait UserSessionTrait
{
    public function currentUser()
    {
        $user = Auth::user();
        if (!$user) {
            $user = Auth::guard('api')->user();
        }
        return $user;
    }

    public function getDefaultTimeZone()
    {
        return 'Asia/Kolkata';
    }

    public function getTimeZoneFromIp()
    {
        return null;
    }

    public function getTimeZome()
    {
        return $this->getTimeZoneFromIp() ? $this->getTimeZoneFromIp() : $this->getDefaultTimeZone();
    }

    public function getUserTimeZone()
    {
        return $this->getTimeZome();
    }
}

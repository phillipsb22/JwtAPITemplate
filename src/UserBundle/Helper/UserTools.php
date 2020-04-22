<?php


namespace App\UserBundle\Helper;


class UserTools
{
    /**
     * @param $email
     * @return bool
     */
    public static function isValidEmailAddress($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}
<?php


namespace App\UtilitiesBundle\ErrorCodes;


/**
 * This class holds all the error codes for the user Bundle. All Codes MUST be prified with UE
 * eg UE0001
 * Class UserBundleErrorCodes
 * @package App\UtilitiesBundle\ErrorCodes
 */
class UserBundleErrorCodes
{
    public const UNDEFINED_USER_ERROR = 'UE0000';
    public const INVALID_EMAIL = 'UE0001';
    public const PASSWORD_COMPLEXITY_ERROR = 'UE0002';
    public const USER_REGISTERED = 'UE0003';
}
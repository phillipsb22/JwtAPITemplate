<?php


namespace App\UtilitiesBundle\Exception;

use App\UtilitiesBundle\ErrorCodes\UserBundleErrorCodes;

/**
 * When this exception is used the message will be returned in the json response in the message.
 * Use this exception when there is an issue with the data that has been supplied and the message should contain
 * a description of the error.
 * It is very important not to catch other exceptions that may be security sensitive and thrown as a UserDataException.
 *
 * Class UserDataException
 * @package App\UtilitiesBundle\Exception
 */
class UserDataException extends \Exception implements BaseExceptionInterface
{
    /** @var $errorCode string */
    private $errorCode;

    /** @var $errors array|null */
    private $error;

    public function __construct(string $message = '', int $code = 400, $errorCode = null, \Throwable $previous = null)
    {
        if ($errorCode === null) {
            $errorCode = UserBundleErrorCodes::UNDEFINED_USER_ERROR;
        }
        $this->setErrorCode($errorCode);

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param array $error
     */
    public function setError(array $error)
    {
        $this->error = $error;
    }

    /**
     * @return array|null
     */
    public function getError()
    {
        return $this->error;
    }
}
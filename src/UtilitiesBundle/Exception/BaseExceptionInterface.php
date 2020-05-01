<?php

namespace App\UtilitiesBundle\Exception;

Interface BaseExceptionInterface extends \Throwable
{
    /**
     * Used to set error codes
     * @param $errorCode
     */
    public function setErrorCode($errorCode);

    /**
     * Used to get error codes relating to exceptions
     * @return string
     */
    public function getErrorCode();

    /**
     * Used to set additonal information that is contained in the error part of the response
     *
     * @param array $error
     * @return mixed
     */
    public function setError(array $error);

    /**
     * Used to return additional error information
     * @return array
     */
    public function getError();
}
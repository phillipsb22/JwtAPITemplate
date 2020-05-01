<?php


namespace App\UtilitiesBundle\Listener;


use App\UtilitiesBundle\Exception\BaseExceptionInterface;
use App\UtilitiesBundle\Exception\UserDataException;
use App\UtilitiesBundle\Helper\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class JsonResponseExceptionListener
{
    const UNDEF_ERROR = 'UDE0000';

    private $env;

    public function __construct(KernelInterface $kernel)
    {
        $this->env = $kernel->getEnvironment();
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ($request->getContentType() === 'json' && preg_match('/^\/api\//', $request->getRequestUri())) {
            $response = $this->createApiResponse($exception);
            $event->setResponse($response);
        }
    }

    /**
     * @param \Exception $exception
     * @return ApiResponse
     */
    private function createApiResponse(\Throwable $exception)
    {
        // Here we hide the exception message so we don't send sensitive information to users
        if (method_exists($exception, 'getErrorCode')) {
            $errorCode = $exception->getErrorCode();
        } else {
            $errorCode = self::UNDEF_ERROR;
        }

        // check and set any additional error information
        if (method_exists($exception, 'getError')) {
            $errors = $exception->getError();
        } else {
            $errors = [];
        }

        if (!$exception instanceof UserDataException && $this->getEnvironment() === "prod") {
            $message = 'An error has occurred with your request Error: ' . $errorCode;
        }

        $statusCode = $exception instanceof BaseExceptionInterface ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        return new ApiResponse($exception->getMessage(), null, $errors, $statusCode);
    }

    /**
     * @return string
     */
    private function getEnvironment()
    {
        return $this->env;
    }
}
<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $exceptionEvent): void
    {
        $message = null;
        $code = null;
        $exception = $exceptionEvent->getThrowable();
        if ($exception->getPrevious()) {
            $message = $exception->getPrevious()->getMessage();
            $code = $exception->getPrevious()->getCode();
        }
        $data = [
            'message' => $message ?? $exception->getMessage()
        ];

        $exceptionEvent->setResponse(new JsonResponse($data, $code ?? Response::HTTP_INTERNAL_SERVER_ERROR));
    }

}

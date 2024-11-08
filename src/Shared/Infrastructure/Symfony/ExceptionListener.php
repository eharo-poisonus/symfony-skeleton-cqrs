<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException (ExceptionEvent $exceptionEvent): void
    {
        if ('dev' !== $_ENV['APP_ENV']) {
            $exception = $exceptionEvent->getThrowable();
            $data = [
                'class' => get_class($exception),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $exception->getMessage()
            ];

            if ($exception instanceof GenericException) {
                $data['code'] = $exception->getCode();
            }
            $exceptionEvent->setResponse(new JsonResponse($data, $data['code']));
        }
    }
}

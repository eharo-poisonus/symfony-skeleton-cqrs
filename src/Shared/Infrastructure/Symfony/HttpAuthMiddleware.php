<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use App\Backoffice\Auth\Application\Authenticate\AuthenticateUserCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final readonly class HttpAuthMiddleware
{
    private const ROUTE_AUTHORIZATION_TYPE = 'AUTH';
    private const BEARER_HEADER = 'Bearer';

    public function __construct(
        private CommandBus $bus
    ) {
    }

    /** @throws Exception */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $typeOfAuthForRequest = Auth::from(
            $event->getRequest()->attributes->get(self::ROUTE_AUTHORIZATION_TYPE, Auth::JWT->value)
        );

        switch ($typeOfAuthForRequest) {
            case Auth::FREE:
                return;
            case Auth::JWT:
                $token = $event->getRequest()->headers->get(self::BEARER_HEADER);
                $this->guardAuthenticationHeaderExist($token);
                $this->authenticate($token, $event);
                return;
            default:
                throw new Exception('Error Auth');
        }
    }

    private function guardAuthenticationHeaderExist(?string $token): void
    {
        if ($token === null) {
            throw new Exception('Error Auth');
        }
    }

    private function authenticate(string $token, RequestEvent $event): void
    {
        try {
            $this->bus->dispatch(new AuthenticateUserCommand($token)); // TODO: Pass Command
        } catch (Exception) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_FORBIDDEN));
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Infrastructure\Api;

use App\Backoffice\Auth\Application\Create\CreateUserCredentialCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Api\BaseController;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostUserCredentialsController extends BaseController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    /** @throws JsonException */
    public function __invoke(Request $request): Response
    {
        $data = $this->jsonDecode($request->getContent());
        $this->commandBus->dispatch(
            new CreateUserCredentialCommand(
                $data->user,
                $data->password
            )
        );
        return $this->response();
    }
}

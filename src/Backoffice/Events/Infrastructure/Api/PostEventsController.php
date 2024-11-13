<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Infrastructure\Api;

use App\Backoffice\Events\Application\Command\Create\CreateEventCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Api\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostEventsController extends BaseController
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $data = $this->jsonDecode($request->getContent());
        $this->commandBus->dispatch(new CreateEventCommand($data->test));
        return new Response();
    }
}

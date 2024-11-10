<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Infrastructure\Api;

use App\Backoffice\Auth\Application\Login\LoginUserQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Api\BaseController;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostLoginController extends BaseController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    /** @throws JsonException */
    public function __invoke(Request $request): Response
    {
        $data = $this->jsonDecode($request->getContent());
        return $this->jsonResponse(
            $this->queryBus->ask(
                    new LoginUserQuery(
                    $data->user,
                    $data->password
                )
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api;

use App\Shared\Domain\Bus\Query\Response as QueryResponse;
use JsonException;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    abstract public function __invoke(Request $request): Response;

    /** @throws JsonException */
    public function jsonDecode(string $json): stdClass
    {
        return json_decode(json: $json, flags: JSON_THROW_ON_ERROR);
    }

    /** @throws JsonException */
    public function jsonEncode(QueryResponse $response): string
    {
        return json_encode(value: $response, flags: JSON_THROW_ON_ERROR);
    }

    public function jsonResponse(QueryResponse $response): JsonResponse
    {
        return new JsonResponse($response);
    }

    public function response(?string $response = null): Response
    {
        return new Response($response);
    }
}

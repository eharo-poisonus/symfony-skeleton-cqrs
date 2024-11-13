<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

class EntityManagerFactory
{
    public const SHARED_CONTEXT_TYPES = [];

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $mappings = MappingSearcher::inContext(null, ['Shared']);
        $customTypes = CustomTypeSearcher::fromPaths(array_keys($mappings));
        $customTypes = array_merge($customTypes, self::SHARED_CONTEXT_TYPES);

        return AppEntityManagerFactory::create(
            $parameters,
            $mappings,
            $customTypes,
            $environment === 'dev'
        );
    }
}

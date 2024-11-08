<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMSetup;

class AppEntityManagerFactory
{
    public static function create(
        array $parameters,
        array $mappingPrefixes,
        array $customTypes,
        bool $isDevMode
    ): EntityManagerInterface {
        $config = self::createConfiguration($isDevMode, $mappingPrefixes);
        $connection = DriverManager::getConnection($parameters, $config);
        self::registerCustomTypes($customTypes);
        return new EntityManager($connection, $config);
    }

    private static function createConfiguration(bool $isDevMode, array $mappingPrefixes): Configuration
    {
        $config = ORMSetup::createConfiguration($isDevMode);
        $xmlDriver = new SimplifiedXmlDriver($mappingPrefixes);
        $config->setMetadataDriverImpl($xmlDriver);
        return $config;
    }

    private static function registerCustomTypes(array $customTypes): void
    {
        array_walk($customTypes, fn($customType) => Type::addType($customType::TYPE, $customType));
    }
}

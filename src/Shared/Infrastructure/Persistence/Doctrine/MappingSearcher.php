<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

final class MappingSearcher
{
    private const MAPPINGS_PATH = '/Infrastructure/Persistence/Doctrine';

    public static function inContext(?string $context, array $contextsToExclude = []): array
    {
        $contextBasePath = self::retrieveContextPath($context);
        $mappings = [];
        $contexts = self::retrieveContexts($contextBasePath);


        foreach ($contexts as $singleContext) {
            $modules = self::retrieveModules("$contextBasePath/$singleContext");
            if (!in_array($singleContext, $contextsToExclude)) {
                foreach ($modules as $module) {
                    $namespace = $singleContext ? "App\\$singleContext\\$module\\Domain" : "App\\$module\\Domain";
                    $mappings[$contextBasePath . $singleContext . '/' . $module . self::MAPPINGS_PATH] = $namespace;
                }
            }
        }

        return $mappings;
    }

    private static function retrieveContextPath(?string $context): string
    {
        $rootPath = str_replace('public', '', $_SERVER['DOCUMENT_ROOT']);
        return sprintf('%s%s/%s', $rootPath, 'src', $context ?? '');
    }

    private static function retrieveContexts(string $contextBasePath): array
    {
        $modules = scandir($contextBasePath);
        return array_filter($modules, fn ($module) => (!in_array($module, ['..', '.', 'Kernel.php'])));
    }

    private static function retrieveModules(string $contextBasePath): array
    {
        $modules = scandir($contextBasePath);
        return array_filter($modules, fn ($module) => (!in_array($module, ['..', '.', 'Kernel.php'])));
    }
}

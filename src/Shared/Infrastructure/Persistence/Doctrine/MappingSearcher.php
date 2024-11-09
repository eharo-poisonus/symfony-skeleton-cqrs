<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

final class MappingSearcher
{
    private const MAPPINGS_PATH = __DIR__ . '/Infrastructure/Persistence/Doctrine';

    public static function inContext(?string $context, array $modulesToExclude): array
    {
        $contextBasePath = self::retrieveContextPath($context);
        $mappings = [];
        $modules = self::retrieveModules($contextBasePath);

        foreach ($modules as $module) {
            if (!in_array($module, $modulesToExclude)) {
                $namespace = $context ? "App\\$context\\$module\\Domain" : "App\\$module\\Domain";
                $mappings[$contextBasePath . $module . self::MAPPINGS_PATH] = $namespace;
            }
        }
        return $mappings;
    }

    private static function retrieveContextPath(?string $context): string
    {
        $rootPath = str_replace('public', '', $_SERVER['DOCUMENT_ROOT']);
        return sprintf('%s%s/%s', $rootPath, 'src', $context ?? '');
    }

    private static function retrieveModules(string $contextBasePath): array
    {
        $modules = scandir($contextBasePath);
        return array_filter($modules, fn ($module) => (!in_array($module, ['..', '.', 'Kernel.php'])));
    }
}

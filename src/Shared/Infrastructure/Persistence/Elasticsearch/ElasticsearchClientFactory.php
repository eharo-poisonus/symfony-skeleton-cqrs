<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Elasticsearch;

use App\Shared\Domain\Utils;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;

final readonly class ElasticsearchClientFactory
{
    public function __invoke(
        string $host,
        string $indexPrefix,
        string $schemasFolder,
        string $environment
    ): ElasticsearchClient {
        $client = ClientBuilder::create()->setHosts([$host])->build();

        $this->generateIndexIfNotExists($client, $indexPrefix, $schemasFolder, $environment);

        return new ElasticsearchClient($client, $indexPrefix);
    }

    private function generateIndexIfNotExists(
        Client $client,
        string $indexPrefix,
        string $schemasFolder,
        string $environment
    ): void {
        if ($environment !== 'prod') {
            return;
        }

        $indexes = Utils::filesIn($schemasFolder, '.json');

        foreach ($indexes as $index) {
            $indexName = str_replace('.json', '', sprintf('%s_%s', $indexPrefix, $index));

            if (!$this->indexExists($client, $indexName)) {
                $indexBody = Utils::jsonDecode(file_get_contents("$schemasFolder/$index"));

                $client->indices()->create(['index' => $indexName, 'body' => $indexBody]);
            }
        }
    }

    private function indexExists(Client $client, string $indexName): bool
    {
        try {
            $client->indices()->getSettings(['index' => $indexName]);

            return true;
        } catch (Exception) {
            return false;
        }
    }
}

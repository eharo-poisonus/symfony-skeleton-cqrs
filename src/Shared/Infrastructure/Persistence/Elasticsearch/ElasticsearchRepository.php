<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Elasticsearch;

use Exception;
use App\Shared\Domain\Criteria\Criteria;

use function Lambdish\Phunctional\get_in;
use function Lambdish\Phunctional\map;

abstract class ElasticsearchRepository
{
    public function __construct(private readonly ElasticsearchClient $client) {}

    abstract protected function aggregateName(): string;

    final public function searchByCriteria(Criteria $criteria): array
    {
        $converter = new ElasticsearchCriteriaConverter();

        $query = $converter->convert($criteria);

        return $this->searchRawElasticsearchQuery($query);
    }

    protected function persist(string $id, array $plainBody): void
    {
        $this->client->persist($this->aggregateName(), $id, $plainBody);
    }

    protected function searchAllInElastic(): array
    {
        return $this->searchRawElasticsearchQuery([]);
    }

    protected function searchRawElasticsearchQuery(array $params): array
    {
        try {
            $result = $this->client->client()->search(array_merge(['index' => $this->indexName()], $params));

            $hits = (array) get_in(['hits', 'hits'], $result, []);

            return map($this->elasticValuesExtractor(), $hits);
        } catch (Exception) {
            return [];
        }
    }

    protected function indexName(): string
    {
        return sprintf('%s_%s', $this->client->indexPrefix(), $this->aggregateName());
    }

    private function elasticValuesExtractor(): callable
    {
        return static fn (array $elasticValues): array => $elasticValues['_source'];
    }
}

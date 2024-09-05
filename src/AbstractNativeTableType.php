<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\Server\Filter\FilterOverride;
use DeviantLab\TabulatorBundle\Server\Sorter\SortOverride;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class AbstractNativeTableType implements NativeTableInterface
{
    public function getConnectionName(): string
    {
        return 'default';
    }

    public function doTransform(array $items): array
    {
        return $items;
    }

    public function configureTable(Table $table): void
    {
        // do nothing
    }

    public function getCountQueryBuilder(Connection $connection, array $params): ?QueryBuilder
    {
        return null;
    }

    public function getSortOverride(): ?SortOverride
    {
        return null;
    }

    public function getFilterOverride(): ?FilterOverride
    {
        return null;
    }
}

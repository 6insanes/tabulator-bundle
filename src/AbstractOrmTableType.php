<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\Server\Filter\FilterOverride;
use DeviantLab\TabulatorBundle\Server\Sorter\SortOverride;
use Doctrine\ORM\Query;

abstract class AbstractOrmTableType implements OrmTableInterface
{
    public function configureQuery(Query $query): void
    {
        // do nothing
    }

    public function configureTable(Table $table): void
    {
        // do nothing
    }

    public function doTransform(array $items, array $params): array
    {
        return $items;
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

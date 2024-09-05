<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;


use DeviantLab\TabulatorBundle\Server\Filter\FilterOverride;
use DeviantLab\TabulatorBundle\Server\Sorter\SortOverride;

final class DoctrineHelper
{
    public function __construct(
        private readonly Paginator $paginator,
        private readonly Sorter $sorter,
        private readonly Filter $filter,
    )
    {

    }

    public function paginate($qb, int $size, int $page): void
    {
        $this->paginator->apply($qb, $size, $page);
    }

    public function sort($qb, array $sort, ?SortOverride $override): void
    {
        $this->sorter->apply($qb, $sort, $override);
    }

    public function filter($qb, array $filter, ?FilterOverride $override): void
    {
        $this->filter->apply($qb, $filter, $override);
    }
}

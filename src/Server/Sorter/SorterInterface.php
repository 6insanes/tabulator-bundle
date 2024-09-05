<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Sorter;

interface SorterInterface
{
    public function apply(object $qb, array $sort, ?SortOverride $override);

    public function supports(object $qb): bool;
}

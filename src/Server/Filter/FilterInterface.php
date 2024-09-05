<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Filter;

interface FilterInterface
{
    public function apply(object $qb, array $filter, ?FilterOverride $override);

    public function supports(object $qb): bool;
}

<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Sorter;


use Doctrine\DBAL\Query\QueryBuilder;

final class NativeHandler implements SorterInterface
{
    public function apply(object $qb, array $sort, ?SortOverride $override)
    {
        assert($qb instanceof QueryBuilder);

        foreach ($sort as $sortItem) {
            $field = $sortItem['field'] ?? null;
            if (!$field) {
                continue;
            }

            $dir = $sortItem['dir'] ?? null;
            if (!$dir) {
                continue;
            }

            $overrideHandler = $override?->get($field);
            if (!$overrideHandler) {
                $overrideHandler = $override?->get(SortOverride::DEFAULT);
            }

            if (!$overrideHandler) {
                throw new \LogicException("You need to implement sort override for field: `{$field}`");
            }

            $overrideHandler($qb, $field, $dir);
        }
    }

    public function supports(object $qb): bool
    {
        return $qb instanceof QueryBuilder;
    }
}

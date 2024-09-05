<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Sorter;

use Doctrine\ORM\QueryBuilder;

final class OrmHandler implements SorterInterface
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

            if ($overrideHandler) {
                $overrideHandler($qb, $field, $dir);
            } else {
                $this->applyDefault($qb, $field, $dir);
            }
        }
    }

    private function applyDefault(QueryBuilder $qb, string $field, string $dir): void
    {
        $fieldName = $qb->getRootAliases()[0].'.'.$field;
        $qb->addOrderBy($fieldName, $dir);
    }

    public function supports(object $qb): bool
    {
        return $qb instanceof QueryBuilder;
    }
}

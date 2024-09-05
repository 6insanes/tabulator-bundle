<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Filter;


use DeviantLab\TabulatorBundle\FilterFunction;
use Doctrine\DBAL\Query\QueryBuilder;

final class NativeHandler implements FilterInterface
{
    public function apply(object $qb, array $filter, ?FilterOverride $override)
    {
        assert($qb instanceof QueryBuilder);

        foreach ($filter as $filterItem) {
            $field = $filterItem['field'] ?? null;
            if (!$field) {
                continue;
            }

            $type = $filterItem['type'] ?? null;
            if (!$type) {
                continue;
            }

            $filterFunction = FilterFunction::tryFrom($type);
            if (!$filterFunction) {
                continue;
            }

            $value = $filterItem['value'] ?? null;

            $overrideHandler = $override?->get($field, $filterFunction);
            if (!$overrideHandler) {
                throw new \LogicException("You need to implement filter override for field and filter function: `{$field}`, `{$type}`");
            }

            $overrideHandler($qb, $value);
        }
    }

    public function supports(object $qb): bool
    {
        return $qb instanceof QueryBuilder;
    }
}

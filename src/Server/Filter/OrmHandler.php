<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Filter;

use DeviantLab\TabulatorBundle\FilterFunction;
use Doctrine\ORM\QueryBuilder;

final class OrmHandler implements FilterInterface
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
            if ($overrideHandler) {
                $overrideHandler($qb, $value);
            } else {
                $this->applyDefault($qb, $field, $filterFunction, $value);
            }
        }
    }

    private function applyDefault(QueryBuilder $qb, string $field, FilterFunction $filterFunction, ?string $value): void
    {
        $aliasField = "{$qb->getRootAliases()[0]}.{$field}";
        switch($filterFunction) {
            case FilterFunction::EQUAL:
                if ($value === null) {
                    $qb->andWhere("{$aliasField} IS NULL");
                } else {
                    $qb->andWhere("{$aliasField} = :{$field}");
                    $qb->setParameter($field, $value);
                }
                break;
            case FilterFunction::ENDS_WITH:
                $qb->andWhere("{$aliasField} LIKE :{$field}");
                $qb->setParameter($field, "%{$value}");
                break;
            case FilterFunction::GREATER_THEN:
                $qb->andWhere("{$aliasField} > :{$field}");
                $qb->setParameter($field, $value);
                break;
            case FilterFunction::GREATER_THEN_OR_EQUAL:
                $qb->andWhere("{$aliasField} >= :{$field}");
                $qb->setParameter($field, $value);
                break;
            case FilterFunction::LESS_THEN:
                $qb->andWhere("{$aliasField} < :{$field}");
                $qb->setParameter($field, $value);
                break;
            case FilterFunction::LESS_THEN_OR_EQUAL:
                $qb->andWhere("{$aliasField} <= :{$field}");
                $qb->setParameter($field, $value);
                break;
            case FilterFunction::LIKE:
                $qb->andWhere("{$aliasField} LIKE :{$field}");
                $qb->setParameter($field, "%{$value}%");
                break;
            case FilterFunction::NOT_EQUAL:
                if ($value === null) {
                    $qb->andWhere("{$aliasField} IS NOT NULL");
                } else {
                    $qb->andWhere("{$aliasField} <> :{$field}");
                    $qb->setParameter($field, $value);
                }
                break;
            case FilterFunction::STARTS_WITH:
                $qb->andWhere("{$aliasField} LIKE :{$field}");
                $qb->setParameter($field, "{$value}%");
                break;
            default:
                throw new \Exception('Unsupported filterFunction');
        }
    }

    public function supports(object $qb): bool
    {
        return $qb instanceof QueryBuilder;
    }
}

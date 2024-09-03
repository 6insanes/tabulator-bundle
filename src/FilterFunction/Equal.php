<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\FilterFunction;

use DeviantLab\TabulatorBundle\FilterFunctionInterface;
use DeviantLab\TabulatorBundle\OrmFilterFunctionInterface;
use Doctrine\ORM\QueryBuilder;

final class Equal implements FilterFunctionInterface, OrmFilterFunctionInterface
{
    public function getName(): string
    {
        return '=';
    }

    public function applyToOrmQueryBuilder(QueryBuilder $qb, string $field, mixed $value): void
    {
        if ($value === null) {
            $qb->andWhere("{$qb->getRootAliases()[0]}.{$field} IS NULL");
        } else {
            $qb->andWhere("{$qb->getRootAliases()[0]}.{$field} = :{$field}");
            $qb->setParameter($field, $value);
        }
    }
}

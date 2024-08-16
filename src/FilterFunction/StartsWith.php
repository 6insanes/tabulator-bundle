<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\FilterFunction;


use DeviantLab\TabulatorBundle\FilterFunctionInterface;
use DeviantLab\TabulatorBundle\OrmFilterFunctionInterface;
use Doctrine\ORM\QueryBuilder;

final class StartsWith implements FilterFunctionInterface, OrmFilterFunctionInterface
{
    public function getName(): string
    {
        return 'starts';
    }

    public function applyToOrmQueryBuilder(QueryBuilder $qb, string $field, mixed $value): void
    {
        $qb->andWhere("{$qb->getRootAliases()[0]}.{$field} LIKE :{$field}");
        $qb->setParameter($field, "{$value}%");
    }
}

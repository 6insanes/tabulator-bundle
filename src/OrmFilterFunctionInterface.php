<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\ORM\QueryBuilder;

interface OrmFilterFunctionInterface
{
    public function applyToOrmQueryBuilder(QueryBuilder $qb, string $field, mixed $value): void;
}

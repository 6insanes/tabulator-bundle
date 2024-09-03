<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractOrmTableType implements OrmTableInterface
{
    public function applyPagination(QueryBuilder $qb, int $size, int $page): void
    {
        $qb->setMaxResults($size);
        $qb->setFirstResult(($page - 1) * $size);
    }

    public function applySort(QueryBuilder $qb, array $sort): void
    {
        foreach ($sort as ['field' => $field, 'dir' => $dir]) {
            $fieldName = $qb->getRootAliases()[0].'.'.$field;
            $qb->addOrderBy($fieldName, $dir);
        }
    }

    public function applyFilter(QueryBuilder $qb, array $filter): void
    {
        $columnsByFieldName = [];
        foreach ($this->getColumns() as $column) {
            $columnsByFieldName[$column->field] = $column;
        }

        foreach ($filter as $item) {
            $column = $columnsByFieldName[$item['field']];

            if (!$column->headerFilter) {
                continue;
            }

            $filterFunction = $column->headerFilter->filterFunction;
            if ($filterFunction instanceof OrmFilterFunctionInterface) {
                $filterFunction->applyToOrmQueryBuilder($qb, $item['field'], $item['value'] ?? null);
            }
        }
    }

    public function configureQuery(Query $query): void
    {
        // do nothing
    }

    public function configureTable(Table $table): void
    {
        // do nothing
    }

    public function doTransform(array $items): array
    {
        return $items;
    }
}

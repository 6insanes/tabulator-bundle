<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

interface OrmTableInterface
{
    public static function getName(): string;

    public function getEntityClass(): string;

    /**
     * @return iterable<Column>
     */
    public function getColumns(): iterable;

    public function getPagination(): ?Pagination;

    public function getSortMode(): SortMode;

    public function getFilterMode(): FilterMode;

    public function getQueryBuilder(ServiceEntityRepository $repo, array $params): QueryBuilder;

    public function doTransform(array $items): array;

    public function applyFilter(QueryBuilder $qb, array $filter): void;

    public function applySort(QueryBuilder $qb, array $sort): void;

    public function applyPagination(QueryBuilder $qb, int $size, int $page): void;
}

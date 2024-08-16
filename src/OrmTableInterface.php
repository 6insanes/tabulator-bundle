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

    public function getQueryBuilder(ServiceEntityRepository $repo): QueryBuilder;

    public function doTransform(array $items): array;
}

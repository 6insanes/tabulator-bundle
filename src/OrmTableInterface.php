<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface OrmTableInterface extends TableInterface
{
    public function getEntityClass(): string;

    public function getQueryBuilder(EntityRepository $repo, array $params): QueryBuilder;

    public function configureQuery(Query $query): void;
}

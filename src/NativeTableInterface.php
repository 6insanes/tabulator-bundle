<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

interface NativeTableInterface extends TableInterface
{
    public function getConnectionName(): string;

    public function getQueryBuilder(Connection $connection, array $params): QueryBuilder;

    public function getCountQueryBuilder(Connection $connection, array $params): ?QueryBuilder;
}

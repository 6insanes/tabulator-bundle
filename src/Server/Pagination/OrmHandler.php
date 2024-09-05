<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Pagination;

use Doctrine\ORM\QueryBuilder;

final class OrmHandler implements PaginatorInterface
{
    public function apply(object $qb, int $size, int $page): void
    {
        assert($qb instanceof QueryBuilder);

        $qb->setMaxResults($size);
        $qb->setFirstResult(($page - 1) * $size);
    }

    public function supports(object $qb): bool
    {
        return $qb instanceof QueryBuilder;
    }
}

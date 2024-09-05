<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server\Pagination;

interface PaginatorInterface
{
    public function apply(object $qb, int $size, int $page);

    public function supports(object $qb): bool;
}

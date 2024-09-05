<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;


use DeviantLab\TabulatorBundle\Server\Pagination\PaginatorInterface;

final class Paginator
{
    public function __construct(private readonly iterable $handlers)
    {

    }

    public function apply(object $qb, int $size, int $page): void
    {
        foreach ($this->handlers as $paginator) {
            /** @var PaginatorInterface $paginator */
            if ($paginator->supports($qb)) {
                $paginator->apply($qb, $size, $page);
                return;
            }
        }

        $className = $qb::class;
        throw new \InvalidArgumentException("Object of class {$className} not supported!");
    }
}

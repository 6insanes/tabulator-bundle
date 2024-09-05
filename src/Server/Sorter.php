<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;

use DeviantLab\TabulatorBundle\Server\Sorter\SorterInterface;
use DeviantLab\TabulatorBundle\Server\Sorter\SortOverride;

final class Sorter
{
    public function __construct(private readonly iterable $handlers)
    {

    }

    public function apply(object $qb, array $sort, ?SortOverride $override): void
    {
        foreach ($this->handlers as $handler) {
            /** @var SorterInterface $handler */
            if ($handler->supports($qb)) {
                $handler->apply($qb, $sort, $override);
                return;
            }
        }

        $className = $qb::class;
        throw new \InvalidArgumentException("Object of class {$className} not supported!");
    }
}

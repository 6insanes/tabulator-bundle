<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Server;

use DeviantLab\TabulatorBundle\Server\Filter\FilterOverride;
use DeviantLab\TabulatorBundle\Server\Sorter\SorterInterface;

final class Filter
{
    public function __construct(private readonly iterable $handlers)
    {

    }

    public function apply(object $qb, array $filter, ?FilterOverride $override): void
    {
        foreach ($this->handlers as $handler) {
            /** @var SorterInterface $handler */
            if ($handler->supports($qb)) {
                $handler->apply($qb, $filter, $override);
                return;
            }
        }

        $className = $qb::class;
        throw new \InvalidArgumentException("Object of class {$className} not supported!");
    }
}

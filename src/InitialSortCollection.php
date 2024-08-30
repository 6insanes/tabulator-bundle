<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;


final class InitialSortCollection extends \IteratorIterator
{
    public function __construct(SortOption ...$options)
    {
        parent::__construct(new \ArrayIterator($options));
    }

    public function current(): SortOption
    {
        return parent::current();
    }
}

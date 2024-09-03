<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle;


final class InitialFilterCollection extends \IteratorIterator
{
    public function __construct(FilterOption ...$options)
    {
        parent::__construct(new \ArrayIterator($options));
    }

    public function current(): FilterOption
    {
        return parent::current();
    }
}

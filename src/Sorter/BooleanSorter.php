<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The boolean sorter will sort column as booleans
 */
final class BooleanSorter implements SorterInterface
{
    public function getName(): string
    {
        return 'boolean';
    }

    public function getParams(): array
    {
        return [];
    }
}

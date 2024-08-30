<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Sorter;

/**
 * The exists sorter will sort column ordering if value has a type of "undefined" or not
 */
final class ExistsSorter implements SorterInterface
{
    public function getName(): string
    {
        return 'exists';
    }

    public function getParams(): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;

/**
 * The count function counts the number of non-empty cells in a column
 * (cells that do not have a value of null, undefined or "").
 */
final class Count implements ColumnCalculationInterface
{
    public function getName(): string
    {
        return 'count';
    }

    public function getParams(): array
    {
        return [];
    }
}

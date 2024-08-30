<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;

/**
 * The unique function counts the number of unique non-empty values in a column
 * (cells that do not have a value of null, undefined or "").
 */
final class Unique implements ColumnCalculationInterface
{
    public function getName(): string
    {
        return 'unique';
    }

    public function getParams(): array
    {
        return [];
    }
}

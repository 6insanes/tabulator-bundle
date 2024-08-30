<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\ColumnCalculation;

/**
 * The concat function joins the values of all cells in a column together as a string.
 */
final class Concatenate implements ColumnCalculationInterface
{
    public function getName(): string
    {
        return 'concat';
    }

    public function getParams(): array
    {
        return [];
    }
}
